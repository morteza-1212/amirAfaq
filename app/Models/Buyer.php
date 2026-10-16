<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product',
        'quantity',
        'destination_country',
        'destination_port',
        'packaging',
        'delivery_time',
        'incoterms',
        'payment_terms',
        'company_information',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* ============================================================
     |  Constants
     ============================================================ */

    public const STATUSES = [
        'new'       => ['fa' => 'جدید',        'ar' => 'جديد',        'en' => 'New'],
        'reviewed'  => ['fa' => 'بررسی‌شده',   'ar' => 'تمت المراجعة', 'en' => 'Reviewed'],
        'contacted' => ['fa' => 'تماس گرفته',  'ar' => 'تم الاتصال',   'en' => 'Contacted'],
        'closed'    => ['fa' => 'بسته‌شده',    'ar' => 'مغلق',         'en' => 'Closed'],
    ];

    public const STATUS_COLORS = [
        'new'       => 'primary',
        'reviewed'  => 'info',
        'contacted' => 'warning',
        'closed'    => 'success',
    ];

    /* ============================================================
     |  Accessors
     ============================================================ */

    public function getStatusLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::STATUSES[$this->status][$locale]
            ?? self::STATUSES[$this->status]['fa']
            ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    /* ============================================================
     |  Scopes
     ============================================================ */

    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('product', 'like', "%{$term}%")
                ->orWhere('destination_country', 'like', "%{$term}%")
                ->orWhere('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('company_information', 'like', "%{$term}%");
        });
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }
}
