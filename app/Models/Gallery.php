<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'activity_type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * زبان‌های پشتیبانی‌شده
     */
    public const LOCALES = [
        'fa' => 'فارسی',
        'ar' => 'العربية',
        'en' => 'English',
    ];

    public const DEFAULT_LOCALE = 'fa';

    /**
     * نوع فعالیت‌ها (چندزبانه)
     */
    /**
     * نوع فعالیت‌ها (چندزبانه + توضیحات فارسی)
     */
    public const ACTIVITY_TYPES = [
        'commerce' => [
            'labels' => [
                'fa' => 'بازرگانی',
                'ar' => 'التجارة',
                'en' => 'Commerce',
            ],
            'description' => 'خرید و فروش کالا و خدمات در بازارهای داخلی و بین‌المللی',
        ],
        'logistics' => [
            'labels' => [
                'fa' => 'لجستیک',
                'ar' => 'الخدمات اللوجستية',
                'en' => 'Logistics',
            ],
            'description' => 'حمل و نقل، انبارداری و مدیریت زنجیره تأمین کالا',
        ],
        'exhibition' => [
            'labels' => [
                'fa' => 'نمایشگاه',
                'ar' => 'المعارض',
                'en' => 'Exhibition',
            ],
            'description' => 'برگزاری و حضور در نمایشگاه‌های تخصصی داخلی و بین‌المللی',
        ],
        'exports' => [
            'labels' => [
                'fa' => 'صادرات',
                'ar' => 'الصادرات',
                'en' => 'Exports',
            ],
            'description' => 'ارسال کالا و محصولات به بازارهای خارج از کشور',
        ],
        'imports' => [
            'labels' => [
                'fa' => 'واردات',
                'ar' => 'الواردات',
                'en' => 'Imports',
            ],
            'description' => 'ورود کالا و محصولات از بازارهای خارجی به کشور',
        ],
        'global_markets' => [
            'labels' => [
                'fa' => 'بازارهای جهانی',
                'ar' => 'الأسواق العالمية',
                'en' => 'Global Markets',
            ],
            'description' => 'حضور فعال و توسعه روابط تجاری در بازارهای بین‌المللی',
        ],
    ];

    /* ============================================================
     |  Relationships
     ============================================================ */

    public function translations(): HasMany
    {
        return $this->hasMany(GalleryTranslation::class);
    }

    /**
     * ترجمه زبان جاری
     */
    public function translation()
    {
        return $this->hasOne(GalleryTranslation::class)
            ->where('locale', app()->getLocale());
    }

    /**
     * ترجمه زبان مشخص
     */
    public function translationFor(string $locale)
    {
        return $this->hasOne(GalleryTranslation::class)
            ->where('locale', $locale);
    }

    /* ============================================================
     |  Accessors
     ============================================================ */

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function getActivityTypeLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return self::ACTIVITY_TYPES[$this->activity_type][$locale]
            ?? self::ACTIVITY_TYPES[$this->activity_type][self::DEFAULT_LOCALE]
            ?? $this->activity_type;
    }

    /**
     * دسترسی سریع به فیلدهای ترجمه با fallback
     */
    public function getTitleAttribute(): ?string
    {
        return $this->translatedField('title');
    }

    public function getSlugAttribute(): ?string
    {
        return $this->translatedField('slug');
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translatedField('description');
    }

    public function getAltTextAttribute(): ?string
    {
        return $this->translatedField('alt_text');
    }

    /**
     * خواندن فیلد ترجمه با fallback به زبان پیش‌فرض
     */
    protected function translatedField(string $field): ?string
    {
        $locale = app()->getLocale();

        // اگر relation لود شده باشد از آن استفاده کن
        if ($this->relationLoaded('translations')) {
            $current = $this->translations->firstWhere('locale', $locale);
            if ($current && $current->{$field}) {
                return $current->{$field};
            }

            $fallback = $this->translations->firstWhere('locale', self::DEFAULT_LOCALE);

            return $fallback?->{$field};
        }

        // در غیر این صورت کوئری بزن
        $translation = $this->translations()
            ->where('locale', $locale)
            ->first();

        if ($translation?->{$field}) {
            return $translation->{$field};
        }

        return $this->translations()
            ->where('locale', self::DEFAULT_LOCALE)
            ->value($field);
    }

    /* ============================================================
     |  Scopes
     ============================================================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    /**
     * جستجو در فیلدهای ترجمه (فقط زبان جاری)
     */
    public function scopeSearch($query, string $term, ?string $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        return $query->whereHas('translations', function ($q) use ($term, $locale) {
            $q->where('locale', $locale)
                ->where(function ($sub) use ($term) {
                    $sub->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
        });
    }

    /**
     * فیلتر روی slug زبان مشخص (برای روت‌ها)
     */
    public function scopeWhereSlug($query, string $slug, ?string $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        return $query->whereHas('translations', function ($q) use ($slug, $locale) {
            $q->where('locale', $locale)->where('slug', $slug);
        });
    }

    /* ============================================================
     |  Helpers
     ============================================================ */

    /**
     * تولید slug یکتا برای یک زبان
     */
    public static function generateUniqueSlug(string $title, string $locale, ?int $ignoreId = null): string
    {
        $base = trim($title);
        $base = preg_replace('/\s+/u', '-', $base);
        $base = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $base);
        $base = mb_strtolower($base, 'UTF-8');

        if ($locale === 'en') {
            $base = Str::slug($base);
        }

        $base = $base ?: 'gallery';
        $slug = $base;
        $count = 1;

        while (
        GalleryTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('gallery_id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }
}
