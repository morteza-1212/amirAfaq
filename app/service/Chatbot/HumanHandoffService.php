<?php

namespace App\service\Chatbot;

use App\Models\Conversation;
use Illuminate\Support\Facades\DB;

class HumanHandoffService
{
    /**
     * ارجاع مکالمه به کارشناس انسانی
     */
    public function requestHumanAgent(
        Conversation $conversation
    ): void {

        DB::transaction(function () use ($conversation) {

            // اگر مکالمه قبلاً بسته شده باشد، ارجاع نده
            if ($conversation->status === 'closed') {
                return;
            }

            // اگر قبلاً در انتظار کارشناس است، دوباره کاری نکن
            if ($conversation->status === 'waiting_for_agent') {
                return;
            }

            // تغییر وضعیت مکالمه
            $conversation->update([
                'status' => 'waiting_for_agent',
            ]);
        });
    }
}
