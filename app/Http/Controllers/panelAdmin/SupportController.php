<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * وضعیت‌های مجاز برای فیلتر
     */
    private const ALLOWED_STATUSES = [
        'bot',
        'waiting_for_agent',
        'assigned',
        'closed',
    ];

    /**
     * زبان‌های مجاز برای فیلتر
     */
    private const ALLOWED_LOCALES = ['fa', 'en', 'ar'];

    /**
     * تعداد آیتم در هر صفحه
     */
    private const PER_PAGE = 15;

    /* =========================================================
       INDEX — فهرست مکالمات
    ========================================================= */
    public function index(Request $request): View
    {
        $query = Conversation::query()
            ->select([
                'id',
                'public_id',
                'session_id',
                'visitor_name',
                'visitor_email',
                'visitor_phone',
                'locale',
                'status',
                'subject',
                'assigned_to',
                'last_message_at',
                'closed_at',
                'created_at',
                'updated_at',
            ])
            ->with(['latestMessage']);

        // فیلتر جستجو
        if ($request->filled('q')) {
            $search = trim((string) $request->input('q'));

            if ($search !== '') {
                $query->where(function ($builder) use ($search) {
                    $builder->where('public_id', 'like', "%{$search}%");

                    if (ctype_digit($search)) {
                        $builder->orWhere('id', (int) $search);
                    }

                    $builder->orWhere('visitor_name', 'like', "%{$search}%")
                        ->orWhere('visitor_email', 'like', "%{$search}%");
                });
            }
        }

        // فیلتر وضعیت
        if ($request->filled('status')
            && in_array($request->input('status'), self::ALLOWED_STATUSES, true)) {
            $query->where('status', $request->input('status'));
        }

        // فیلتر زبان
        if ($request->filled('locale')
            && in_array($request->input('locale'), self::ALLOWED_LOCALES, true)) {
            $query->where('locale', $request->input('locale'));
        }

        // مرتب‌سازی
        $conversations = $query
            ->orderByRaw("
                CASE status
                    WHEN 'waiting_for_agent' THEN 0
                    WHEN 'assigned'          THEN 1
                    WHEN 'bot'               THEN 2
                    WHEN 'closed'            THEN 3
                    ELSE 4
                END
            ")
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        // آمار
        $stats = Conversation::query()
            ->selectRaw("
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'waiting_for_agent' THEN 1 ELSE 0 END) AS waiting,
                SUM(CASE WHEN status = 'assigned'          THEN 1 ELSE 0 END) AS assigned,
                SUM(CASE WHEN status = 'closed'            THEN 1 ELSE 0 END) AS closed
            ")
            ->first();

        $stats = [
            'total'    => (int) ($stats->total    ?? 0),
            'waiting'  => (int) ($stats->waiting  ?? 0),
            'assigned' => (int) ($stats->assigned ?? 0),
            'closed'   => (int) ($stats->closed   ?? 0),
        ];

        return view('panelAdmin.chatbot.support.index', compact(
            'conversations',
            'stats'
        ));
    }

    /* =========================================================
       CHAT — نمایش یک مکالمه
    ========================================================= */
    public function chat(Conversation $conversation): View
    {
        $messages = $conversation->messages()
            ->orderBy('id')
            ->get();

        return view('panelAdmin.chatbot.support.chat', compact(
            'conversation',
            'messages'
        ));
    }

    /* =========================================================
       MESSAGES — دریافت پیام‌های جدید (AJAX)
    ========================================================= */
    public function messages(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'after_id' => ['nullable', 'integer', 'min:0'],
        ]);

        $afterId = (int) ($validated['after_id'] ?? 0);

        $messages = $conversation->messages()
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get([
                'id',
                'sender_type',
                'content',
                'created_at',
            ]);

        return response()->json([
            'status'   => $conversation->status,
            'messages' => $messages,
        ]);
    }

    /* =========================================================
       REPLY — ارسال پاسخ کارشناس
    ========================================================= */
    public function reply(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        if ($conversation->status === 'closed') {
            return response()->json([
                'message' => 'این مکالمه بسته شده است.',
            ], 422);
        }

        $message = $conversation->messages()->create([
            'sender_type' => 'agent',
            'content'     => trim($validated['content']),
        ]);

        $conversation->update([
            'status'          => 'assigned',
            'last_message_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'status'  => $conversation->status,
            'message' => $message->only([
                'id',
                'sender_type',
                'content',
                'created_at',
            ]),
        ]);
    }

    /* =========================================================
       ASSIGN — اختصاص مکالمه به کارشناس فعلی
    ========================================================= */
    public function assign(Request $request, Conversation $conversation)
    {
        if ($conversation->status === 'closed') {
            return back()->with('error', 'این مکالمه بسته شده است و قابل اختصاص نیست.');
        }

        $conversation->update([
            'status'      => 'assigned',
            'assigned_to' => auth()->id(),
        ]);

        return back()->with('success', 'مکالمه به شما اختصاص یافت.');
    }

    /* =========================================================
       CLOSE — بستن مکالمه
    ========================================================= */
    public function close(Request $request, Conversation $conversation)
    {
        if ($conversation->status === 'closed') {
            return back()->with('error', 'این مکالمه قبلاً بسته شده است.');
        }

        $conversation->update([
            'status'    => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'مکالمه با موفقیت بسته شد.');
    }

    /* =========================================================
       REOPEN — بازگشایی مکالمه
    ========================================================= */
    public function reopen(Request $request, Conversation $conversation)
    {
        if ($conversation->status !== 'closed') {
            return back()->with('error', 'این مکالمه بسته نیست.');
        }

        $conversation->update([
            'status'    => 'waiting_for_agent',
            'closed_at' => null,
        ]);

        return back()->with('success', 'مکالمه بازگشایی شد.');
    }
}
