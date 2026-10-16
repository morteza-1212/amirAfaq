<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.' . $this->message->conversation_id),
        ];
    }

    // app/Events/MessageSent.php — اصلاح ستون body → content
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id'          => $this->message->id,
                'sender_type' => $this->message->sender_type,
                'content'     => $this->message->content,
                'created_at'  => $this->message->created_at->toIso8601String(),
            ],
        ];
    }
}
