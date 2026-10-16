<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'image',
        'icon',
        'sort_order',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
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
        'agricultural' => ['fa' => 'کشاورزی',  'ar' => 'زراعي',    'en' => 'Agricultural'],
        'industrial'   => ['fa' => 'صنعتی',    'ar' => 'صناعي',    'en' => 'Industrial'],
        'raw_material' => ['fa' => 'مواد خام', 'ar' => 'مواد خام', 'en' => 'Raw Material'],
    ];

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(ProductGroupTranslation::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'product_group_id');
    }

    /* ============================================================
     |  Boot (تولید خودکار code)
     ============================================================ */

    protected static function booted(): void
    {
        static::creating(function (ProductGroup $group) {
            if (empty($group->code)) {
                $group->code = static::generateUniqueCode();
            }
        });
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    /**
     * تولید کد خودکار
     * فرمت: GRP-YYYYMMDD-XXXX
     */
    public static function generateUniqueCode(): string
    {
        $prefix = 'GRP-' . now()->format('Ymd') . '-';

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
    public static function generateUniqueSlug(string $name, string $locale, ?int $ignoreId = null): string
    {
        $base = trim($name);
        $base = preg_replace('/\s+/u', '-', $base);
        $base = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $base);
        $base = mb_strtolower($base, 'UTF-8');

        if ($locale === 'en') {
            $base = Str::slug($base);
        }

        $base = $base ?: 'group';
        $slug = $base;
        $count = 1;

        while (
        ProductGroupTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('product_group_id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    /**
     * ترجمه زبان جاری با fallback
     */
    public function translation(?string $locale = null): ?ProductGroupTranslation
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

    public function getNameAttribute(): string
    {
        return $this->translation()?->name ?? ('گروه #' . $this->id);
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

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getTypeLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::TYPES[$this->type][$locale]
            ?? self::TYPES[$this->type][self::DEFAULT_LOCALE]
            ?? $this->type;
    }

    /* ============================================================
     |  Scopes
     ============================================================ */

    public function scopeActive($query)
    {
        return $query->where('status', true);
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
                ->orWhereHas('translations', function ($sub) use ($term) {
                    $sub->where('name', 'like', "%{$term}%")
                        ->orWhere('short_description', 'like', "%{$term}%");
                });
        });
    }
}
