<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradeTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_code',
        'transaction_type',
        'image',
        'quantity',
        'unit',
        'transport_method',
        'delivery_time',
        'contract_date',
        'delivery_date',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'quantity'        => 'decimal:3',
        'sort_order'      => 'integer',
        'is_published'    => 'boolean',
        'contract_date'   => 'date',
        'delivery_date'   => 'date',
    ];

    /* ============================================================
     |  Constants
     ============================================================ */

    public const LOCALES = [
        'fa' => 'فارسی',
        'ar' => 'العربية',
        'en' => 'English',
    ];

    public const DEFAULT_LOCALE = 'fa';

    public const TRANSACTION_TYPES = [
        'export' => ['fa' => 'صادرات', 'ar' => 'التصدير', 'en' => 'Export'],
        'import' => ['fa' => 'واردات', 'ar' => 'الاستيراد', 'en' => 'Import'],
    ];

    public const TRANSPORT_METHODS = [
        'sea'  => ['fa' => 'دریایی', 'ar' => 'بحري',    'en' => 'Sea'],
        'air'  => ['fa' => 'هوایی',  'ar' => 'جوي',      'en' => 'Air'],
        'land' => ['fa' => 'زمینی',  'ar' => 'بري',      'en' => 'Land'],
    ];

    public const UNITS = [
        'ton'    => ['fa' => 'تن',      'ar' => 'طن',      'en' => 'Ton'],
        'kg'     => ['fa' => 'کیلوگرم', 'ar' => 'كيلوغرام', 'en' => 'Kg'],
        'piece'  => ['fa' => 'عدد',     'ar' => 'قطعة',    'en' => 'Piece'],
        'liter'  => ['fa' => 'لیتر',    'ar' => 'لتر',     'en' => 'Liter'],
        'meter'  => ['fa' => 'متر',     'ar' => 'متر',     'en' => 'Meter'],
        'carton' => ['fa' => 'کارتن',   'ar' => 'كرتون',   'en' => 'Carton'],
    ];

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(trade_transaction_translation::class);
    }

    /* ============================================================
     |  Boot
     ============================================================ */

    protected static function booted(): void
    {
        static::creating(function (TradeTransaction $transaction) {
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = static::generateUniqueCode();
            }
        });
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    public static function generateUniqueCode(): string
    {
        $prefix = 'TRX-' . now()->format('Ymd') . '-';

        $lastCode = static::withTrashed()
            ->where('transaction_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('transaction_code');

        $nextNumber = $lastCode
            ? ((int) substr($lastCode, -4)) + 1
            : 1;

        $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::withTrashed()->where('transaction_code', $code)->exists()) {
            $nextNumber++;
            $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }

//    public function translation(?string $locale = null): ?trade_transaction_translation
//    {
//        $locale = $locale ?? app()->getLocale();
//
//        if ($this->relationLoaded('translations')) {
//            return $this->translations->firstWhere('locale', $locale)
//                ?? $this->translations->firstWhere('locale', self::DEFAULT_LOCALE);
//        }
//
//        return $this->translations()
//            ->where('locale', $locale)
//            ->first()
//            ?? $this->translations()
//                ->where('locale', self::DEFAULT_LOCALE)
//                ->first();
//    }

    /* ============================================================
     |  Accessors
     ============================================================ */

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getTitleAttribute(): ?string
    {
        return $this->translation()?->title;
    }

    public function getProductAttribute(): ?string
    {
        return $this->translation()?->product;
    }

    public function getTransactionTypeLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::TRANSACTION_TYPES[$this->transaction_type][$locale]
            ?? self::TRANSACTION_TYPES[$this->transaction_type][self::DEFAULT_LOCALE]
            ?? $this->transaction_type;
    }

    public function getTransportMethodLabelAttribute(): ?string
    {
        if (! $this->transport_method) {
            return null;
        }

        $locale = app()->getLocale();

        return self::TRANSPORT_METHODS[$this->transport_method][$locale]
            ?? self::TRANSPORT_METHODS[$this->transport_method][self::DEFAULT_LOCALE]
            ?? $this->transport_method;
    }

    public function getUnitLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::UNITS[$this->unit][$locale]
            ?? self::UNITS[$this->unit][self::DEFAULT_LOCALE]
            ?? $this->unit;
    }

    /* ============================================================
     |  Scopes
     ============================================================ */

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('transaction_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('transaction_code', 'like', "%{$term}%")
                ->orWhereHas('translations', function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('product', 'like', "%{$term}%")
                        ->orWhere('destination_country', 'like', "%{$term}%");
                });
        });
    }
    /* ============================================================
 |  Helpers
 ============================================================ */

    /**
     * ترجمه زبان جاری با fallback
     */
    public function translation(?string $locale = null): ?trade_transaction_translation
    {
        $locale = $locale ?? app()->getLocale();

        if ($this->relationLoaded('translations')) {
            return $this->translations->firstWhere('locale', $locale)
                ?? $this->translations->firstWhere('locale', self::DEFAULT_LOCALE);
        }

        return $this->translations()
            ->where('locale', $locale)
            ->first()
            ?? $this->translations()
                ->where('locale', self::DEFAULT_LOCALE)
                ->first();
    }

    /**
     * ترجمه با زبان خاص (برای نمایش چندزبانه)
     */
    public function translationFor(string $locale): ?trade_transaction_translation
    {
        if ($this->relationLoaded('translations')) {
            return $this->translations->firstWhere('locale', $locale)
                ?? $this->translations->firstWhere('locale', self::DEFAULT_LOCALE);
        }

        return $this->translations()
            ->where('locale', $locale)
            ->first()
            ?? $this->translations()
                ->where('locale', self::DEFAULT_LOCALE)
                ->first();
    }
}
