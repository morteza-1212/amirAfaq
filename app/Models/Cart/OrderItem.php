<?php
namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','product_shop_id','product_name','unit_price','quantity','total_price',
    ];

    public function order()   { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(\App\Models\Shop\ProductShop::class, 'product_shop_id'); }
}
