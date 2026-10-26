<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sku',
        'image',
        'gallery',
        'product_type',
        'unit',
        'minimum_order_quantity',
        'maximum_supply_quantity',
        'origin_country',
        'packaging_type',
        'storage_conditions',
        'shelf_life',
        'is_exportable',
        'is_available_domestic',
        'is_featured',
        'is_active',
        'sort_order',
        'specifications',
    ];

    protected $casts = [
        'gallery'                  => 'array',
        'specifications'           => 'array',
        'is_exportable'            => 'boolean',
        'is_available_domestic'    => 'boolean',
        'is_featured'              => 'boolean',
        'is_active'                => 'boolean',
        'minimum_order_quantity'   => 'decimal:3',
        'maximum_supply_quantity'  => 'decimal:3',
        'sort_order'               => 'integer',
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

    public const PRODUCT_TYPES = [
        'agricultural' => ['fa' => 'کشاورزی',       'ar' => 'زراعي',           'en' => 'Agricultural'],
        'food'         => ['fa' => 'غذایی',         'ar' => 'غذائي',            'en' => 'Food'],
        'industrial'   => ['fa' => 'صنعتی',         'ar' => 'صناعي',            'en' => 'Industrial'],
        'petrochemical'=> ['fa' => 'پتروشیمی',      'ar' => 'بتروكيماوي',       'en' => 'Petrochemical'],
        'mineral'      => ['fa' => 'معدنی',         'ar' => 'معدني',            'en' => 'Mineral'],
        'construction' => ['fa' => 'ساختمانی',      'ar' => 'مواد البناء',       'en' => 'Construction'],
        'textile'      => ['fa' => 'نساجی',         'ar' => 'المنسوجات',         'en' => 'Textile'],
        'handicraft'   => ['fa' => 'صنایع دستی',    'ar' => 'الحرف اليدوية',     'en' => 'Handicraft'],
        'other'        => ['fa' => 'سایر',          'ar' => 'أخرى',              'en' => 'Other'],
    ];

    public const UNITS = [
        'ton'    => ['fa' => 'تن',        'ar' => 'طن',       'en' => 'Ton'],
        'kg'     => ['fa' => 'کیلوگرم',   'ar' => 'كيلوغرام', 'en' => 'Kg'],
        'piece'  => ['fa' => 'عدد',       'ar' => 'قطعة',     'en' => 'Piece'],
        'liter'  => ['fa' => 'لیتر',      'ar' => 'لتر',      'en' => 'Liter'],
        'meter'  => ['fa' => 'متر',       'ar' => 'متر',      'en' => 'Meter'],
        'carton' => ['fa' => 'کارتن',     'ar' => 'كرتون',    'en' => 'Carton'],
        'bag'    => ['fa' => 'کیسه',      'ar' => 'كيس',      'en' => 'Bag'],
    ];

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(ProductExportTranslation::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    /**
     * ترجمه زبان جاری با fallback
     */
    public function translation(?string $locale = null): ?ProductExportTranslation
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

        return array_map(fn ($path) => asset('storage/' . $path), $this->gallery);
    }

    public function getNameAttribute(): ?string
    {
        return $this->translation()?->name;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->translation()?->short_description;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translation()?->description;
    }

    public function getProductTypeLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::PRODUCT_TYPES[$this->product_type][$locale]
            ?? self::PRODUCT_TYPES[$this->product_type][self::DEFAULT_LOCALE]
            ?? $this->product_type;
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

    public function scopeExportable($query)
    {
        return $query->where('is_exportable', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('sku', 'like', "%{$term}%")
                ->orWhereHas('translations', function ($sub) use ($term) {
                    $sub->where('name', 'like', "%{$term}%")
                        ->orWhere('short_description', 'like', "%{$term}%");
                });
        });
    }
}
