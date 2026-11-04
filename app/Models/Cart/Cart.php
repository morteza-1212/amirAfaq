<?php

namespace App\Models\Cart;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'token',
        'guest_email',
        'guest_phone',
        'guest_name',
        'status',
        'subtotal',
        'items_count',
        'ip_address',
        'user_agent',
        'last_activity_at',
        'converted_at',
    ];

    protected $casts = [
        'subtotal'         => 'integer',
        'items_count'      => 'integer',
        'last_activity_at' => 'datetime',
        'converted_at'     => 'datetime',
    ];

    protected $hidden = [
        'ip_address',
        'user_agent',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Cart $cart) {
            if (empty($cart->token)) {
                $cart->token = Str::random(64);
            }

            if (empty($cart->status)) {
                $cart->status = 'active';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForGuest($query, string $token)
    {
        return $query
            ->whereNull('user_id')
            ->where('token', $token);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * آیا سبد متعلق به مهمان است؟
     */
    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    /**
     * آیا سبد فعال است؟
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * آیا سبد خالی است؟
     */
    public function isEmpty(): bool
    {
        return (int) $this->items_count === 0;
    }

    /**
     * آیا اطلاعات تماس برای تسویه کامل است؟
     */
    public function hasContactInfo(): bool
    {
        return !empty($this->guest_phone)
            && (
                !empty($this->user_id)
                || !empty($this->guest_name)
            );
    }

    /*
    |--------------------------------------------------------------------------
    | محاسبه مجدد سبد خرید
    |--------------------------------------------------------------------------
    */

    public function recalculate(): void
    {
        $items = $this->items()->get([
            'quantity',
            'total_price',
        ]);

        $this->subtotal = (int) $items->sum('total_price');

        $this->items_count = (int) $items->sum('quantity');

        $this->last_activity_at = now();

        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | تبدیل سبد به سفارش
    |--------------------------------------------------------------------------
    */

    public function markAsConverted(): void
    {
        if ($this->status === 'converted') {
            return;
        }

        $this->update([
            'status'       => 'converted',
            'converted_at' => now(),
        ]);
    }
}
