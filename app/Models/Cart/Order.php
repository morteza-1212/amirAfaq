<?php

namespace App\Models\Cart;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'postal_code',
        'city',
        'province',
        'subtotal',
        'shipping_cost',
        'discount',
        'total_amount',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'subtotal'      => 'integer',
        'shipping_cost' => 'integer',
        'discount'      => 'integer',
        'total_amount'  => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function successfulPayment(): HasOne
    {
        return $this->hasOne(Payment::class)
            ->where('status', 'success')
            ->latestOfMany();
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
