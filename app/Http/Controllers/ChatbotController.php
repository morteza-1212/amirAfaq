<?php

namespace App\Http\Controllers;

use App\Events\AgentNeeded;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\service\FaqSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * زبان‌های پشتیبانی‌شده.
     */
    private const SUPPORTED_LOCALES = ['fa', 'en', 'ar'];

    /**
     * وضعیت‌هایی که مکالمه در آن‌ها فعال است (می‌توان پیام فرستاد).
     */
    private const ACTIVE_STATUSES = ['bot', 'waiting_for_agent', 'assigned'];

    /**
     * وضعیت‌هایی که در آن‌ها پاسخ خودکار ارسال نمی‌شود
     * (چون کارشناس در حال پاسخ‌دهی است).
     */
    private const AGENT_STATUSES = ['waiting_for_agent', 'assigned'];

    public function __construct(
        protected FaqSearchService $faqSearch
    ) {}

    /* =========================================================
       START — شروع یا بازیابی مکالمه
    ========================================================= */
    public function start(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        $locale    = $this->resolveLocale();

        $conversation = Conversation::query()
            ->where('session_id', $sessionId)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->latest('id')
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'public_id'       => (string) Str::uuid(),
                'session_id'      => $sessionId,
                'locale'          => $locale,
                'status'          => 'bot',
                'last_message_at' => now(),
            ]);

            Log::info('[chatbot.start] new conversation', [
                'conversation_id' => $conversation->id,
                'session_id'      => $sessionId,
            ]);
        }

        return response()->json([
            'success'    => true,
            'session_id' => $sessionId,
            'status'     => $conversation->status,
        ]);
    }

    /* =========================================================
       SEND — دریافت پیام کاربر و پاسخ‌دهی
    ========================================================= */
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $content   = trim($validated['content']);
        $locale    = $this->resolveLocale();
        $sessionId = $request->session()->getId();

        Log::info('[chatbot.send] incoming', [
            'session_id' => $sessionId,
            'locale'     => $locale,
            'content'    => mb_substr($content, 0, 100),
        ]);

        try {
            $result = DB::transaction(function () use ($content, $locale, $sessionId) {
                /* -----------------------------------------
                   ۱. پیدا کردن یا ساختن مکالمه فعال
                ----------------------------------------- */
                $conversation = Conversation::query()
                    ->where('session_id', $sessionId)
                    ->whereIn('status', self::ACTIVE_STATUSES)
                    ->latest('id')
                    ->first();

                if (!$conversation) {
                    $conversation = Conversation::create([
                        'public_id'       => (string) Str::uuid(),
                        'session_id'      => $sessionId,
                        'locale'          => $locale,
                        'status'          => 'bot',
                        'last_message_at' => now(),
                    ]);

                    Log::info('[chatbot.send] new conversation created', [
                        'conversation_id' => $conversation->id,
                    ]);
                }

                /* -----------------------------------------
                   ۲. ثبت پیام کاربر
                ----------------------------------------- */
                $userMessage = Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_type'     => 'user',
                    'content'         => $content,
                ]);

                $conversation->update([
                    'last_message_at' => now(),
                ]);

                /* -----------------------------------------
                   ۳. اگر مکالمه در اختیار کارشناس است،
                      پاسخ خودکار نمی‌دهیم.
                ----------------------------------------- */
                if (in_array($conversation->status, self::AGENT_STATUSES, true)) {
                    Log::info('[chatbot.send] forwarded to agent (skip FAQ)', [
                        'conversation_id' => $conversation->id,
                        'status'          => $conversation->status,
                    ]);

                    event(new MessageSent($userMessage));

                    return [
                        'status'   => $conversation->status,
                        'messages' => [$userMessage],
                    ];
                }

                /* -----------------------------------------
                   ۴. جستجو در FAQ
                ----------------------------------------- */
                Log::info('[chatbot.send] searching FAQ', [
                    'content' => $content,
                    'locale'  => $locale,
                ]);

                $faq = $this->faqSearch->findBestAnswer($content, $locale);

                Log::info('[chatbot.send] FAQ result', [
                    'found'    => $faq ? true : false,
                    'faq_slug' => $faq?->slug,
                ]);

                if ($faq) {
                    $translation = $faq->translation($locale);

                    Log::info('[chatbot.send] translation', [
                        'found'  => $translation ? true : false,
                        'locale' => $translation?->locale,
                    ]);

                    if ($translation) {
                        // ⚠️ incrementUsage حذف شد چون ستون usage_count وجود ندارد

                        $botMessage = Message::create([
                            'conversation_id' => $conversation->id,
                            'sender_type'     => 'assistant',
                            'content'         => $translation->answer,
                        ]);

                        $conversation->update([
                            'last_message_at' => now(),
                            'status'          => 'bot',
                        ]);

                        event(new MessageSent($botMessage));

                        Log::info('[chatbot.send] FAQ answered', [
                            'faq_id'          => $faq->id,
                            'conversation_id' => $conversation->id,
                        ]);

                        return [
                            'status'   => 'bot',
                            'messages' => [$userMessage, $botMessage],
                        ];
                    }
                }

                /* -----------------------------------------
                   ۵. پاسخ پیدا نشد → ارجاع به کارشناس
                ----------------------------------------- */
                $conversation->update([
                    'status'          => 'waiting_for_agent',
                    'last_message_at' => now(),
                ]);

                $systemMessage = Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_type'     => 'system',
                    'content'         => $this->supportNotice($locale),
                ]);

                Log::info('[chatbot.send] forwarded to agent (no FAQ)', [
                    'conversation_id' => $conversation->id,
                ]);

                event(new MessageSent($userMessage));
                event(new AgentNeeded($conversation));

                return [
                    'status'   => 'waiting_for_agent',
                    'messages' => [$userMessage, $systemMessage],
                ];
            });

            return response()->json([
                'success'  => true,
                'status'   => $result['status'],
                'messages' => $this->formatMessages($result['messages']),
            ]);

        } catch (\Throwable $e) {
            Log::error('[chatbot.send] error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            // در حالت debug، خطای دقیق را برگردان
            if (config('app.debug')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'خطا در پردازش پیام. لطفاً دوباره تلاش کنید.',
            ], 500);
        }
    }

    /* =========================================================
       MESSAGES — دریافت پیام‌های جدید بعد از یک id
    ========================================================= */
    public function messages(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'after_id' => ['nullable', 'integer', 'min:0'],
        ]);

        $sessionId = $request->session()->getId();
        $afterId   = (int) ($validated['after_id'] ?? 0);

        $conversation = Conversation::query()
            ->where('session_id', $sessionId)
            ->latest('id')
            ->first();

        if (!$conversation) {
            return response()->json([
                'success'  => true,
                'status'   => null,
                'messages' => [],
            ]);
        }

        $messages = Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get(['id', 'sender_type', 'content', 'created_at']);

        return response()->json([
            'success'  => true,
            'status'   => $conversation->status,
            'messages' => $this->formatMessages($messages),
        ]);
    }

    /* =========================================================
       HELPERS
    ========================================================= */

    /**
     * زبان درخواست را تشخیص می‌دهد.
     */
    private function resolveLocale(): string
    {
        // ۱. از session (اگر کاربر زبان را انتخاب کرده باشد)
        $locale = session('locale');

        // ۲. اگر نبود، از app
        if (!$locale) {
            $locale = app()->getLocale();
        }

        // ۳. اگر در لیست مجاز نبود، پیش‌فرض fa
        return in_array($locale, self::SUPPORTED_LOCALES, true)
            ? $locale
            : 'fa';
    }

    /**
     * فرمت استاندارد پیام‌ها برای JSON.
     */
    private function formatMessages(iterable $messages): array
    {
        $result = [];

        foreach ($messages as $m) {
            $result[] = [
                'id'          => $m->id,
                'sender_type' => $m->sender_type,
                'content'     => $m->content,
                'created_at'  => $m->created_at?->toIso8601String(),
            ];
        }

        return $result;
    }

    /**
     * پیام اطلاع‌رسانی ارجاع به کارشناس.
     */
    private function supportNotice(string $locale): string
    {
        return match ($locale) {
            'en' => 'Sorry, I couldn\'t find an exact answer to your question. Your message has been forwarded to our support team. Please wait for an agent to respond.',
            'ar' => 'عذراً، لم أتمكن من العثور على إجابة دقيقة لسؤالك. تم تحويل رسالتك إلى فريق الدعم. يرجى الانتظار حتى يرد أحد الوكلاء.',
            default => 'متأسفانه پاسخ دقیقی برای سوالت پیدا نکردم. پیام شما برای کارشناسان پشتیبانی ارسال شد؛ لطفاً منتظر پاسخ باشید. 🌱',
        };
    }
}
