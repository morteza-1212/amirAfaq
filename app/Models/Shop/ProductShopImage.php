<?php

namespace App\Models\Shop;

use App\Models\Shop\ProductShop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductShopImage extends Model
{
    protected $fillable = [
        'product_shop_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function productShop(): BelongsTo
    {
        return $this->belongsTo(
            ProductShop::class,
            'product_shop_id'
        );
    }
}
