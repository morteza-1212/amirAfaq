<?php

namespace App\Models\Cart;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'subtotal'         => 'integer',
        'items_count'      => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * آیا این سبد متعلق به مهمان است؟
     */
    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    public function isEmpty(): bool
    {
        return $this->items_count === 0;
    }

    /**
     * آیا اطلاعات تماس برای تسویه کامل است؟
     */
    public function hasContactInfo(): bool
    {
        return ! empty($this->guest_phone)
            && (! empty($this->user_id) || ! empty($this->guest_name));
    }

    public function recalculate(): void
    {
        $items = $this->items()->get(['quantity', 'total_price']);

        $this->subtotal    = $items->sum('total_price');
        $this->items_count = $items->sum('quantity');
        $this->last_activity_at = now();
        $this->save();
    }
}
