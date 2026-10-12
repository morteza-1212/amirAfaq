<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTranlation extends Model
{
    /**
     * نام جدول (چون با Convention لاراول متفاوت است، صریحاً تعریف می‌شود)
     */
    protected $table = 'product_tranlations';

    protected $fillable = [
        'product_id',
        'locale',
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'features',
        'packaging',
        'shipping_info',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'alt_text',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
