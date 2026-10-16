<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'conversation_id',
        'lead_type',
        'name',
        'company_name',
        'email',
        'phone',
        'product',
        'quantity',
        'unit',
        'destination_country',
        'destination_port',
        'packaging',
        'incoterms',
        'payment_terms',
        'delivery_time',
        'description',
        'status',
        'assigned_to',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
