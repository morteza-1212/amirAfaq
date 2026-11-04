<?php

namespace App\Models\Cart;

use App\Models\Shop\ProductShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_shop_id',
        'product_name',
        'product_sku',
        'product_image',
        'unit_price',
        'quantity',
        'total_price',
        'discount',
    ];

    protected $casts = [
        'unit_price'  => 'integer',
        'quantity'    => 'integer',
        'total_price' => 'integer',
        'discount'    => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            ProductShop::class,
            'product_shop_id'
        );
    }

    /**
     * نام جایگزین برای ارتباط با محصول.
     */
    public function productShop(): BelongsTo
    {
        return $this->belongsTo(
            ProductShop::class,
            'product_shop_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * مبلغ نهایی این آیتم پس از کسر تخفیف.
     */
    public function getNetPriceAttribute(): int
    {
        return max(
            0,
            (int) $this->total_price - (int) $this->discount
        );
    }
}
