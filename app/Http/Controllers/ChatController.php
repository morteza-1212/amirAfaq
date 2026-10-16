<?php

namespace App\Http\Controllers;

use App\Events\AgentNe;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Services\AiSupportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private const GUEST_COOKIE = 'jr_chat_guest';
    private const OPEN_STATUSES = ['bot', 'waiting_agent', 'with_agent'];
    private const GUEST_EMAIL = 'guest-chat@system.local';

    /**
     * شروع یا بازیابی مکالمهٔ باز فعلی — برای کاربر لاگین‌کرده یا مهمان.
     * POST /chat/start
     */
    public function start(Request $request): JsonResponse
    {
        try {
            // ===== کاربر لاگین کرده =====
            if ($request->user()) {
                $conversation = Conversation::where('customer_id', $request->user()->id)
                    ->whereIn('status', self::OPEN_STATUSES)
                    ->latest()
                    ->first();

                if (!$conversation) {
                    $conversation = Conversation::create([
                        'customer_id' => $request->user()->id,
                        'status' => 'bot',
                        'guest_token' => null,
                    ]);
                }

                return response()->json([
                    'conversation_id' => $conversation->id,
                    'status' => $conversation->status,
                ]);
            }

            // ===== کاربر مهمان (لاگین نشده) =====

            // دریافت یا ایجاد توکن مهمان از کوکی
            $guestToken = $request->cookie(self::GUEST_COOKIE);

            if (!$guestToken) {
                $guestToken = (string) Str::uuid();
            }

            // دریافت یا ایجاد کاربر مهمان سیستم
            $guestUserId = $this->getGuestUserId();

            if (!$guestUserId) {
                return response()->json([
                    'error' => 'امکان ایجاد کاربر مهمان وجود ندارد.',
                    'message' => 'لطفاً دوباره تلاش کنید.'
                ], 500);
            }

            // جستجوی مکالمه باز برای این مهمان
            $conversation = Conversation::where('customer_id', $guestUserId)
                ->where('guest_token', $guestToken)
                ->whereIn('status', self::OPEN_STATUSES)
                ->latest()
                ->first();

            // اگر مکالمه‌ای وجود نداشت، یک مکالمه جدید ایجاد کن
            if (!$conversation) {
                $conversation = Conversation::create([
                    'customer_id' => $guestUserId,
                    'guest_token' => $guestToken,
                    'status' => 'bot',
                ]);
            }

            // تنظیم کوکی برای یک سال
            Cookie::queue(self::GUEST_COOKIE, $guestToken, 60 * 24 * 365);

            return response()->json([
                'conversation_id' => $conversation->id,
                'status' => $conversation->status,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in ChatController@start: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'خطا در شروع مکالمه',
                'message' => 'لطفاً دوباره تلاش کنید.'
            ], 500);
        }
    }

    /**
     * دریافت پیام‌های یک مکالمه.
     * GET /chat/{conversation}/messages?after_id=123
     */
    public function messages(Conversation $conversation, Request $request): JsonResponse
    {
        try {
            $this->authorizeAccess($conversation, $request);

            $query = $conversation->messages()->orderBy('id');

            $afterId = $request->query('after_id', $request->query('since'));
            if (filled($afterId)) {
                $query->where('id', '>', (int) $afterId);
            }

            return response()->json(
                $query->get(['id', 'sender_type', 'body', 'created_at'])
            );

        } catch (\Exception $e) {
            Log::error('Error in ChatController@messages: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'خطا در دریافت پیام‌ها',
                'message' => 'لطفاً دوباره تلاش کنید.'
            ], 500);
        }
    }

    /**
     * ارسال پیام جدید از سمت مشتری (لاگین‌کرده یا مهمان).
     * POST /chat/{conversation}/send
     */
    public function send(Conversation $conversation, Request $request, AiSupportService $ai): JsonResponse
    {
        try {
            $this->authorizeAccess($conversation, $request);

            $request->validate([
                'body' => 'required|string|max:2000'
            ]);

            // تعیین sender_id
            $senderId = $request->user()?->id ?? $conversation->customer_id;

            // اگر sender_id مشخص نیست، خطا برگردان
            if (!$senderId) {
                return response()->json([
                    'error' => 'شناسه کاربر نامعتبر است.',
                    'message' => 'لطفاً دوباره تلاش کنید.'
                ], 400);
            }

            // ذخیره پیام کاربر
            $customerMsg = Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'customer',
                'sender_id' => $senderId,
                'body' => $request->body,
            ]);

            // ارسال رویداد برای سایر کاربران
            try {
                broadcast(new MessageSent($customerMsg))->toOthers();
            } catch (\Exception $e) {
                Log::warning('Broadcast failed: ' . $e->getMessage());
            }

            // پردازش پاسخ بر اساس وضعیت مکالمه
            if ($conversation->status === 'bot') {
                $this->handleBotResponse($conversation, $request->body, $ai);
            } elseif ($conversation->status === 'waiting_agent' || $conversation->status === 'with_agent') {
                // اگر منتظر اپراتور هستیم، پیامی برای اطلاع ارسال می‌کنیم
                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_type' => 'bot',
                    'body' => 'پیام شما دریافت شد. به محض اینکه اپراتور پاسخ دهد، به شما اطلاع داده می‌شود.',
                ]);
            }

            // دریافت وضعیت به‌روز شده
            $conversation->refresh();

            return response()->json([
                'status' => $conversation->status,
                'message' => [
                    'id' => $customerMsg->id,
                    'sender_type' => $customerMsg->sender_type,
                    'body' => $customerMsg->body,
                    'created_at' => $customerMsg->created_at->toIso8601String(),
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'خطا در اعتبارسنجی',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error in ChatController@send: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'خطا در ارسال پیام',
                'message' => 'لطفاً دوباره تلاش کنید.'
            ], 500);
        }
    }

    /**
     * انتقال مکالمه به اپراتور
     * POST /chat/{conversation}/transfer-to-agent
     */
    public function transferToAgent(Conversation $conversation, Request $request): JsonResponse
    {
        try {
            $this->authorizeAccess($conversation, $request);

            // فقط ادمین یا اپراتور می‌توانند انتقال دهند
            $user = $request->user();
            if (!$user || !in_array($user->role, ['admin', 'agent'])) {
                return response()->json([
                    'error' => 'شما اجازه انتقال مکالمه را ندارید.'
                ], 403);
            }

            $conversation->update([
                'status' => 'with_agent',
                'agent_id' => $user->id,
            ]);

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'agent',
                'sender_id' => $user->id,
                'body' => 'اپراتور به مکالمه متصل شد. چگونه می‌توانم کمک کنم؟',
            ]);

            broadcast(new AgentNeeded($conversation));

            return response()->json([
                'status' => $conversation->status,
                'message' => 'مکالمه با موفقیت به اپراتور منتقل شد.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in ChatController@transferToAgent: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'خطا در انتقال به اپراتور',
                'message' => 'لطفاً دوباره تلاش کنید.'
            ], 500);
        }
    }

    /**
     * بستن مکالمه
     * POST /chat/{conversation}/close
     */
    public function close(Conversation $conversation, Request $request): JsonResponse
    {
        try {
            $this->authorizeAccess($conversation, $request);

            // فقط ادمین یا اپراتور می‌توانند مکالمه را ببندند
            $user = $request->user();
            if (!$user || !in_array($user->role, ['admin', 'agent'])) {
                return response()->json([
                    'error' => 'شما اجازه بستن مکالمه را ندارید.'
                ], 403);
            }

            $conversation->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'agent',
                'sender_id' => $user->id,
                'body' => 'مکالمه توسط اپراتور بسته شد. در صورت نیاز مجدداً با ما تماس بگیرید.',
            ]);

            return response()->json([
                'status' => $conversation->status,
                'message' => 'مکالمه با موفقیت بسته شد.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in ChatController@close: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'خطا در بستن مکالمه',
                'message' => 'لطفاً دوباره تلاش کنید.'
            ], 500);
        }
    }

    /**
     * پردازش پاسخ ربات
     */
    private function handleBotResponse(Conversation $conversation, string $message, AiSupportService $ai): void
    {
        try {
            $result = $ai->answer($message);

            // بررسی نیاز به اپراتور انسانی
            if (isset($result['needs_human']) && $result['needs_human'] === true) {
                $conversation->update(['status' => 'waiting_agent']);

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_type' => 'bot',
                    'body' => 'در حال انتقال شما به پشتیبانی انسانی هستیم، لطفاً چند لحظه صبر کنید 🙏',
                ]);

                broadcast(new AgentNeeded($conversation));
            } else {
                // پاسخ ربات
                $answer = $result['answer'] ?? 'پاسخی دریافت نشد. لطفاً دوباره تلاش کنید.';

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_type' => 'bot',
                    'body' => $answer,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);

            // در صورت خطای سرویس AI، پیام خطا ارسال می‌شود
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_type' => 'bot',
                'body' => 'سیستم پاسخگویی موقتاً در دسترس نیست. لطفاً دوباره تلاش کنید یا با پشتیبانی تماس بگیرید.',
            ]);
        }
    }

    /**
     * بررسی دسترسی: کاربر لاگین‌کردهٔ صاحب مکالمه، مهمانی با کوکی درست،
     * یا اپراتوری که این مکالمه به او اختصاص دارد.
     */
    private function authorizeAccess(Conversation $conversation, Request $request): void
    {
        $user = $request->user();

        // ===== کاربر لاگین کرده =====
        if ($user) {
            // بررسی اینکه آیا کاربر صاحب مکالمه است یا اپراتور
            if ($user->id === $conversation->customer_id || $user->id === $conversation->agent_id) {
                return;
            }

            // اگر کاربر ادمین است، اجازه دسترسی به همه مکالمات را دارد
            if ($user->role === 'admin') {
                return;
            }

            abort(403, 'شما به این مکالمه دسترسی ندارید.');
        }

        // ===== کاربر مهمان =====
        $guestToken = $request->cookie(self::GUEST_COOKIE);

        // اگر کوکی مهمان وجود ندارد
        if (!$guestToken) {
            abort(403, 'شما به این مکالمه دسترسی ندارید.');
        }

        // بررسی اینکه مکالمه مربوط به یک مهمان است
        if (is_null($conversation->guest_token)) {
            abort(403, 'این مکالمه برای مهمانان نیست.');
        }

        // بررسی تطابق توکن مهمان با توکن موجود در مکالمه
        if (!hash_equals($conversation->guest_token, $guestToken)) {
            abort(403, 'شما به این مکالمه دسترسی ندارید.');
        }
    }

    /**
     * ساخت یا بازیابی کاربر مشترک «مهمان» — فقط یک‌بار ساخته می‌شود و id آن کش می‌شود.
     */
    private function getGuestUserId(): int
    {
        return Cache::rememberForever('chat_guest_system_user_id', function () {
            try {
                // ابتدا بررسی می‌کنیم کاربر مهمان وجود دارد یا نه
                $user = User::where('email', self::GUEST_EMAIL)->first();

                if (!$user) {
                    // ایجاد کاربر مهمان با ساختار صحیح جدول
                    $user = User::create([
                        'first_name' => 'مهمان',
                        'last_name' => 'سیستم',
                        'user_name' => 'guest_chat_' . Str::random(12),
                        'email' => self::GUEST_EMAIL,
                        'phone' => '0' . rand(1000000000, 9999999999),
                        'role' => 'user',
                        'password' => Hash::make(Str::random(40)),
                        'email_verified_at' => now(),
                        'is_agent' => false,
                        'wallet_balance' => 0,
                    ]);

                    Log::info('Guest user created successfully', ['user_id' => $user->id]);
                } else {
                    // اگر کاربر وجود دارد، اطمینان از کامل بودن اطلاعات
                    $needsUpdate = false;

                    if (is_null($user->email_verified_at)) {
                        $user->email_verified_at = now();
                        $needsUpdate = true;
                    }

                    // اطمینان از وجود user_name
                    if (empty($user->user_name) || $user->user_name === 'guest_chat_system') {
                        $user->user_name = 'guest_chat_' . Str::random(12);
                        $needsUpdate = true;
                    }

                    if ($needsUpdate) {
                        $user->save();
                        Log::info('Guest user updated', ['user_id' => $user->id]);
                    }
                }

                return $user->id;

            } catch (\Exception $e) {
                Log::error('Error creating/finding guest user: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);

                // در صورت خطا، یک کاربر جدید با روش جایگزین ایجاد می‌کنیم
                $user = User::create([
                    'first_name' => 'مهمان',
                    'last_name' => 'سیستم_' . Str::random(6),
                    'user_name' => 'guest_' . Str::random(12),
                    'email' => 'guest_' . Str::random(8) . '@system.local',
                    'phone' => '0' . rand(1000000000, 9999999999),
                    'role' => 'user',
                    'password' => Hash::make(Str::random(40)),
                    'email_verified_at' => now(),
                    'is_agent' => true,
                    'wallet_balance' => 0,
                ]);

                return $user->id;
            }
        });
    }
}
