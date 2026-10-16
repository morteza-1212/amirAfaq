<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class trade_transaction_translation extends Model
{
    protected $fillable = [
        'trade_transaction_id',
        'locale',
        'title',
        'product',
        'origin_country',
        'destination_country',
        'packaging',
        'alt_text',
        'description',
    ];

    public function tradeTransaction(): BelongsTo
    {
        return $this->belongsTo(TradeTransaction::class);
    }
}
