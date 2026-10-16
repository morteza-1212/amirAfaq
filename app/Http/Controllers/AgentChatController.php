<?php

namespace App\Http\Controllers;

use App\Events\AgentAssigned;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentChatController extends Controller
{
    /**
     * صفحهٔ اصلی پنل اپراتور.
     * GET /admin/chat
     */
    public function index(Request $request): View
    {
        $waiting = Conversation::where('status', 'waiting_agent')
            ->with(['customer:id,user_name', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        $mine = Conversation::where('agent_id', $request->user()->id)
            ->where('status', 'with_agent')
            ->with(['customer:id,user_name', 'messages' => fn ($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        return view('admin-chat-index', compact('waiting', 'mine'));
    }

    /**
     * لیست مکالمه‌های در انتظار — برای polling دورهٔ سایدبار.
     * GET /admin/chat/waiting-list
     */
    public function waitingList(): JsonResponse
    {
        $waiting = Conversation::where('status', 'waiting_agent')
            ->with(['customer:id,user_name'])
            ->latest()
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'customer_name' => $c->customer->name ?? 'مشتری',
                'last_message' => optional($c->messages()->latest()->first())->body,
                'created_at' => $c->created_at->toIso8601String(),
            ]);

        return response()->json($waiting);
    }

    /**
     * گرفتن مالکیت یک مکالمهٔ در انتظار.
     * POST /admin/chat/{conversation}/claim
     */
    public function claim(Conversation $conversation, Request $request): JsonResponse
    {
        $updated = Conversation::where('id', $conversation->id)
            ->where('status', 'waiting_agent')
            ->update([
                'agent_id' => $request->user()->id,
                'status' => 'with_agent',
            ]);

        if (! $updated) {
            return response()->json([
                'error' => 'این مکالمه قبلاً توسط اپراتور دیگری گرفته شده است.',
            ], 409);
        }

        $conversation->refresh();
        broadcast(new AgentAssigned($conversation));

        return response()->json(['status' => 'ok', 'conversation_id' => $conversation->id]);
    }

    /**
     * دریافت پیام‌های یک مکالمه (برای اپراتور).
     * GET /admin/chat/{conversation}/messages?after_id=123
     *
     * پارامتر after_id برای polling استفاده می‌شود: اگر داده شود فقط
     * پیام‌های جدیدتر از آن id برگردانده می‌شود.
     */
    public function messages(Conversation $conversation, Request $request): JsonResponse
    {
        $this->authorizeAgentAccess($conversation, $request);

        $query = $conversation->messages()->orderBy('id');

        $afterId = $request->query('after_id', $request->query('since'));
        if (filled($afterId)) {
            $query->where('id', '>', (int) $afterId);
        }

        $messages = $query->get(['id', 'sender_type', 'body', 'created_at']);

        return response()->json($messages);
    }

    /**
     * ارسال پاسخ از سمت اپراتور.
     * POST /admin/chat/{conversation}/send
     */
    public function send(Conversation $conversation, Request $request): JsonResponse
    {
        $this->authorizeAgentAccess($conversation, $request);

        $request->validate(['body' => 'required|string|max:2000']);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'agent',
            'sender_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'ok',
            // frontend این آبجکت را برای به‌روزرسانی lastMessageId استفاده می‌کند
            'message' => [
                'id' => $message->id,
                'sender_type' => $message->sender_type,
                'body' => $message->body,
                'created_at' => $message->created_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * بستن مکالمه.
     * POST /admin/chat/{conversation}/close
     */
    public function close(Conversation $conversation, Request $request): JsonResponse
    {
        $this->authorizeAgentAccess($conversation, $request);
        $conversation->update(['status' => 'closed']);

        return response()->json(['status' => 'closed']);
    }

    private function authorizeAgentAccess(Conversation $conversation, Request $request): void
    {
        abort_unless($conversation->agent_id === $request->user()->id, 403, 'این مکالمه به شما اختصاص ندارد.');
    }
}
