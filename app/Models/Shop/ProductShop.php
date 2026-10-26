<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductShop extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\ProductShopFactory> */
    use HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    public function images(): HasMany
    {
        return $this->hasMany(
            ProductShopImage::class,
            'product_shop_id'
        )->orderBy('sort_order');
    }
}
