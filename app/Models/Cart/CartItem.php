<?php

namespace App\Models\Cart;

use App\Models\Shop\ProductShop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 'product_shop_id', 'quantity', 'unit_price', 'total_price',
    ];

    protected $casts = [
        'quantity'    => 'integer',
        'unit_price'  => 'integer',
        'total_price' => 'integer',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductShop::class, 'product_shop_id');
    }
}
