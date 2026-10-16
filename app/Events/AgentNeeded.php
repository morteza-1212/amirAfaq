<?php

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AgentNeeded implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public Conversation $conversation)
    {
    }

    public function broadcastOn(): array
    {
        // کانال خصوصی مشترک بین همهٔ اپراتورها؛ فقط کاربران is_agent=true اجازهٔ گوش دادن دارند
        return [
            new PrivateChannel('agents-notifications'),
        ];
    }

    // app/Events/AgentNeeded.php
    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversation->id,
            'visitor_name'    => $this->conversation->visitor_name ?? 'مشتری',
            'last_message'    => optional(
                $this->conversation->messages()->latest()->first()
            )->content,
        ];
    }
}
