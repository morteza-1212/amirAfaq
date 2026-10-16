<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_group_id',
        'parent_id',
        'code',
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

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /* ============================================================
     |  Boot (تولید خودکار code)
     ============================================================ */

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->code)) {
                $category->code = static::generateUniqueCode();
            }
        });
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    /**
     * تولید کد خودکار
     * فرمت: CAT-YYYYMMDD-XXXX
     */
    public static function generateUniqueCode(): string
    {
        $prefix = 'CAT-' . now()->format('Ymd') . '-';

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

        $base = $base ?: 'category';
        $slug = $base;
        $count = 1;

        while (
        CategoryTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('category_id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }

    /**
     * ترجمه زبان جاری با fallback
     */
    public function translation(?string $locale = null): ?CategoryTranslation
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

    /**
     * نام کامل با والد
     * مثلاً: "میوه‌ها > مرکبات > پرتقال"
     */
    public function getFullNameAttribute(): string
    {
        $names = [];
        $current = $this;

        while ($current) {
            $names[] = $current->name ?? '—';
            $current = $current->parent;
        }

        return implode(' / ', array_reverse($names));
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

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function scopeOfGroup($query, int $groupId)
    {
        return $query->where('product_group_id', $groupId);
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
