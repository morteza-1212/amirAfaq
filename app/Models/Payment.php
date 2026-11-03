<?php

namespace App\Models;

use App\Models\Cart\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'gateway',
        'metadata',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'   => 'integer',
            'metadata' => 'array',
            'paid_at'  => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }
}
