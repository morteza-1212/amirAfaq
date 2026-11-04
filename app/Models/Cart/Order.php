<?php

namespace App\Models\Cart;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'cart_id',
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
        'payment_method',
        'status',
        'admin_note',
        'status_history',
        'shipping_method',
        'shipping_tracking_code',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'updated_by',
    ];

    protected $casts = [
        'subtotal'       => 'integer',
        'shipping_cost'  => 'integer',
        'discount'       => 'integer',
        'total_amount'   => 'integer',
        'status_history' => 'array',
        'shipped_at'     => 'datetime',
        'delivered_at'   => 'datetime',
        'cancelled_at'   => 'datetime',
    ];

    protected $hidden = [
        'admin_note',
        'status_history',
        'updated_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (blank($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');

        $count = self::withTrashed()
                ->where('order_number', 'like', "ORD-{$year}-%")
                ->count() + 1;

        return sprintf('ORD-%s-%06d', $year, $count);
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

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment\::class);
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, ?string $status)
    {
        return $query->when(
            filled($status),
            fn ($q) => $q->where('status', $status)
        );
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (blank($term)) {
            return $query;
        }

        $term = '%' . $term . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('order_number', 'like', $term)
                ->orWhere('tracking_code', 'like', $term)
                ->orWhere('customer_phone', 'like', $term)
                ->orWhere('customer_name', 'like', $term)
                ->orWhere('customer_email', 'like', $term);
        });
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isCancellable(): bool
    {
        return in_array(
            $this->status,
            ['pending', 'paid', 'processing'],
            true
        );
    }

    /**
     * تغییر وضعیت سفارش همراه با ثبت تاریخچه.
     */
    public function changeStatus(
        string $newStatus,
        ?int $adminId = null,
        ?string $note = null
    ): void {
        if ($this->status === $newStatus) {
            return;
        }

        $history = $this->status_history ?? [];

        $history[] = [
            'from' => $this->status,
            'to'   => $newStatus,
            'by'   => $adminId,
            'note' => $note,
            'at'   => now()->toIso8601String(),
        ];

        $data = [
            'status'         => $newStatus,
            'status_history' => $history,
            'updated_by'     => $adminId,
        ];

        match ($newStatus) {
            'shipped'   => $data['shipped_at'] = now(),
            'delivered' => $data['delivered_at'] = now(),
            'cancelled' => $data['cancelled_at'] = now(),
            default     => null,
        };

        $this->update($data);
    }
}
