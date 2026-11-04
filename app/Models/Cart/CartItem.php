<?php

namespace App\Models\Cart;

use App\Models\Shop\ProductShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_shop_id',
        'quantity',
        'unit_price',
        'total_price',
        'product_name',
    ];

    protected $casts = [
        'quantity'    => 'integer',
        'unit_price'  => 'integer',
        'total_price' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
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
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * تغییر تعداد محصول و محاسبه مجدد قیمت.
     */
    public function setQuantity(int $quantity): void
    {
        $quantity = max(1, $quantity);

        $this->quantity = $quantity;

        $this->total_price = $this->unit_price * $quantity;

        $this->save();

        $this->cart?->recalculate();
    }
}
