<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'code',
        'type',
        'image',
        'gallery',
        'is_active',
        'is_featured',
        'sort_order',
        'stock_status',
        'unit',
        'weight',
        'origin_country',
        'minimum_order',
        'preparation_days',
        'sku',
    ];

    protected $casts = [
        'gallery'          => 'array',
        'is_active'        => 'boolean',
        'is_featured'      => 'boolean',
        'weight'           => 'decimal:3',
        'minimum_order'    => 'decimal:3',
        'sort_order'       => 'integer',
        'preparation_days' => 'integer',
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

    public const TYPES = [
        'export' => ['fa' => 'صادرات',           'ar' => 'التصدير',           'en' => 'Export'],
        'import' => ['fa' => 'واردات',            'ar' => 'الاستيراد',         'en' => 'Import'],
        'both'   => ['fa' => 'صادرات و واردات',  'ar' => 'التصدير والاستيراد', 'en' => 'Both'],
    ];

    public const STOCK_STATUSES = [
        'in_stock'     => ['fa' => 'موجود',   'ar' => 'متوفر',      'en' => 'In Stock'],
        'out_of_stock' => ['fa' => 'ناموجود', 'ar' => 'غير متوفر',  'en' => 'Out of Stock'],
        'on_request'   => ['fa' => 'استعلام', 'ar' => 'حسب الطلب',  'en' => 'On Request'],
    ];

    public const UNITS = [
        'ton'    => ['fa' => 'تن',       'ar' => 'طن',       'en' => 'Ton'],
        'kg'     => ['fa' => 'کیلوگرم',  'ar' => 'كيلوغرام', 'en' => 'Kg'],
        'piece'  => ['fa' => 'عدد',      'ar' => 'قطعة',     'en' => 'Piece'],
        'liter'  => ['fa' => 'لیتر',     'ar' => 'لتر',      'en' => 'Liter'],
        'meter'  => ['fa' => 'متر',      'ar' => 'متر',      'en' => 'Meter'],
        'carton' => ['fa' => 'کارتن',    'ar' => 'كرتون',    'en' => 'Carton'],
    ];

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranlation::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* ============================================================
     |  Boot (تولید خودکار code)
     ============================================================ */

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->code)) {
                $product->code = static::generateUniqueCode();
            }
        });
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    /**
     * تولید کد خودکار
     */
    public static function generateUniqueCode(): string
    {
        $prefix = 'PRD-' . now()->format('Ymd') . '-';

        $lastCode = static::query()
            ->where('code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('code');

        $nextNumber = $lastCode
            ? ((int) substr($lastCode, -4)) + 1
            : 1;

        $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        while (static::where('code', $code)->exists()) {
            $nextNumber++;
            $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    /**
     * تولید slug یکتا در یک زبان
     */
    public static function generateUniqueSlug(string $name, string $locale, ?int $ignoreProductId = null): string
    {
        $base = trim($name);
        $base = preg_replace('/\s+/u', '-', $base);
        $base = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $base);
        $base = mb_strtolower($base, 'UTF-8');

        if ($locale === 'en') {
            $base = Str::slug($base);
        }

        $base = $base ?: 'product';
        $slug = $base;
        $count = 1;

        while (
        ProductTranlation::where('locale', $locale)
            ->where('slug', $slug)
            ->when($ignoreProductId, fn ($q) => $q->where('product_id', '!=', $ignoreProductId))
            ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    /**
     * ترجمه زبان جاری با fallback
     */
    public function translation(?string $locale = null): ?ProductTranlation
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

    /* ============================================================
     |  Accessors
     ============================================================ */

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery)) {
            return [];
        }

        return array_map(
            fn ($path) => asset('storage/' . $path),
            $this->gallery
        );
    }

    public function getNameAttribute(): ?string
    {
        return $this->translation()?->name;
    }

    public function getSlugAttribute(): ?string
    {
        return $this->translation()?->slug;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->translation()?->short_description;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translation()?->description;
    }

    public function getTypeLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::TYPES[$this->type][$locale]
            ?? self::TYPES[$this->type][self::DEFAULT_LOCALE]
            ?? $this->type;
    }

    public function getStockStatusLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::STOCK_STATUSES[$this->stock_status][$locale]
            ?? self::STOCK_STATUSES[$this->stock_status][self::DEFAULT_LOCALE]
            ?? $this->stock_status;
    }

    public function getUnitLabelAttribute(): ?string
    {
        if (! $this->unit) {
            return null;
        }

        $locale = app()->getLocale();

        return self::UNITS[$this->unit][$locale]
            ?? self::UNITS[$this->unit][self::DEFAULT_LOCALE]
            ?? $this->unit;
    }

    /* ============================================================
     |  Scopes
     ============================================================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('code', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhereHas('translations', function ($sub) use ($term) {
                    $sub->where('name', 'like', "%{$term}%")
                        ->orWhere('short_description', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
        });
    }
}
