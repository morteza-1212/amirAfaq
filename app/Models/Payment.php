<?php

namespace App\Models;

use App\Models\Cart\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_number',
        'order_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'gateway',
        'gateway_response',
        'metadata',
        'paid_at',
        'failed_at',
        'refunded_at',
        'verified_by',
        'refunded_by',
        'failure_reason',
    ];

    protected $casts = [
        'amount'           => 'integer',
        'gateway_response' => 'array',
        'metadata'         => 'array',
        'paid_at'          => 'datetime',
        'failed_at'        => 'datetime',
        'refunded_at'      => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            if (blank($payment->payment_number)) {
                $payment->payment_number = static::generatePaymentNumber();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | تولید شماره پرداخت یکتا
    |--------------------------------------------------------------------------
    */

    public static function generatePaymentNumber(): string
    {
        return DB::transaction(function () {

            $year = (int) now()->format('Y');

            $prefix = 'PAY-' . $year . '-';

            // ایجاد شمارنده سال در صورت نبودن
            DB::table('payment_number_sequences')->insertOrIgnore([
                'year'        => $year,
                'last_number' => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // قفل کردن شمارنده برای جلوگیری از شماره تکراری
            $sequence = DB::table('payment_number_sequences')
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                throw new RuntimeException(
                    'امکان دریافت شمارنده شماره پرداخت وجود ندارد.'
                );
            }

            /*
             * بررسی شماره‌های قبلی، حتی پرداخت‌هایی که
             * به صورت Soft Delete حذف شده‌اند.
             */
            $existingNumbers = static::withTrashed()
                ->where('payment_number', 'like', $prefix . '%')
                ->pluck('payment_number');

            $maxExistingNumber = 0;

            foreach ($existingNumbers as $number) {
                if (preg_match('/^PAY-\d{4}-(\d+)$/', $number, $matches)) {
                    $maxExistingNumber = max(
                        $maxExistingNumber,
                        (int) $matches[1]
                    );
                }
            }

            // انتخاب بزرگ‌ترین شمارنده
            $lastNumber = max(
                (int) $sequence->last_number,
                $maxExistingNumber
            );

            $nextNumber = $lastNumber + 1;

            // ذخیره شمارنده جدید
            DB::table('payment_number_sequences')
                ->where('year', $year)
                ->update([
                    'last_number' => $nextNumber,
                    'updated_at'  => now(),
                ]);

            return $prefix . str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | ایجاد اتمیک پرداخت
    |--------------------------------------------------------------------------
    */

    public static function createAtomic(array $attributes): self
    {
        return DB::transaction(function () use ($attributes) {

            // شماره پرداخت فقط توسط سرور تولید می‌شود.
            unset($attributes['payment_number']);

            $attributes['payment_number'] =
                static::generatePaymentNumber();

            return static::create($attributes);

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeGateway($query, string $gateway)
    {
        return $query->where('gateway', $gateway);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (blank($term)) {
            return $query;
        }

        $term = '%' . $term . '%';

        return $query->where(function ($q) use ($term) {

            $q->where('payment_number', 'like', $term)
                ->orWhere('transaction_id', 'like', $term)
                ->orWhereHas('order', function ($oq) use ($term) {

                    $oq->where('order_number', 'like', $term)
                        ->orWhere('tracking_code', 'like', $term);

                });

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRefundable(): bool
    {
        return $this->status === 'success'
            && is_null($this->refunded_at);
    }

    /*
    |--------------------------------------------------------------------------
    | پرداخت موفق
    |--------------------------------------------------------------------------
    */

    public function markAsSuccess(
        ?string $transactionId = null,
        ?array $gatewayResponse = null
    ): void {

        DB::transaction(function () use ($transactionId, $gatewayResponse) {

            $payment = static::whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status === 'success') {
                return;
            }

            if ($payment->status !== 'pending') {
                throw new RuntimeException(
                    'وضعیت این پرداخت اجازه ثبت پرداخت موفق را نمی‌دهد.'
                );
            }

            $payment->update([
                'status' => 'success',

                'transaction_id' =>
                    $transactionId ?? $payment->transaction_id,

                'gateway_response' =>
                    $gatewayResponse ?? $payment->gateway_response,

                'paid_at' => now(),
            ]);

            $order = $payment->order;

            if (!$order) {
                throw new RuntimeException(
                    'سفارش مربوط به این پرداخت پیدا نشد.'
                );
            }

            $order->changeStatus('paid');

            $this->refresh();

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | پرداخت ناموفق
    |--------------------------------------------------------------------------
    */

    public function markAsFailed(
        ?string $reason = null,
        ?array $gatewayResponse = null
    ): void {

        DB::transaction(function () use ($reason, $gatewayResponse) {

            $payment = static::whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status !== 'pending') {
                throw new RuntimeException(
                    'این پرداخت در وضعیت انتظار نیست.'
                );
            }

            $payment->update([
                'status' => 'failed',
                'failure_reason' => $reason,

                'gateway_response' =>
                    $gatewayResponse ?? $payment->gateway_response,

                'failed_at' => now(),
            ]);

            $this->refresh();

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | لغو پرداخت
    |--------------------------------------------------------------------------
    */

    public function markAsCanceled(?string $reason = null): void
    {
        DB::transaction(function () use ($reason) {

            $payment = static::whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status !== 'pending') {
                throw new RuntimeException(
                    'این پرداخت قابل لغو نیست.'
                );
            }

            $payment->update([
                'status' => 'canceled',

                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    [
                        'cancel_reason' => $reason,
                        'canceled_at' => now()->toDateTimeString(),
                    ]
                ),
            ]);

            $this->refresh();

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | بازگشت وجه
    |--------------------------------------------------------------------------
    */

    public function refund(int $adminId, ?string $note = null): void
    {
        DB::transaction(function () use ($adminId, $note) {

            $payment = static::whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if (!$payment->isRefundable()) {
                throw new RuntimeException(
                    'این پرداخت قبلاً بازپرداخت شده یا قابل بازگشت نیست.'
                );
            }

            $payment->update([
                'status'      => 'refunded',
                'refunded_at' => now(),
                'refunded_by' => $adminId,

                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    [
                        'refund_note' => $note,
                    ]
                ),
            ]);

            $order = $payment->order;

            if ($order) {
                $order->changeStatus(
                    'refunded',
                    $adminId,
                    $note
                );
            }

            $this->refresh();

        }, 5);
    }
}
