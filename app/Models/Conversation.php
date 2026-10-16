<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Conversation extends Model
{
    protected $fillable = [
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
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Conversation $conversation) {
            if (empty($conversation->public_id)) {
                $conversation->public_id = (string) Str::uuid();
            }
        });
    }


    public function lead(): HasOne
    {
        return $this->hasOne(Lead::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * قدیمی‌ترین پیام (اختیاری - برای نمایش شروع گفتگو)
     */
    public function firstMessage(): HasOne
    {
        return $this->hasOne(Message::class)->oldestOfMany();
    }

    /**
     * همه پیام‌ها
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * اپراتور مسئول
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
