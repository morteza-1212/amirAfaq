<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'product_group_id' => 'integer',
            'parent_id'       => 'integer',
            'sort_order'      => 'integer',
            'status'          => 'boolean',
            'is_featured'     => 'boolean',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Product Group
    |--------------------------------------------------------------------------
    */

    /**
     * گروه محصولی که این دسته به آن تعلق دارد.
     */
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(
            ProductGroup::class,
            'product_group_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Parent / Children
    |--------------------------------------------------------------------------
    */

    /**
     * دسته والد
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'parent_id'
        );
    }


    /**
     * زیر دسته‌های مستقیم
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            Category::class,
            'parent_id'
        )->orderBy('sort_order');
    }


    /**
     * زیر دسته‌ها به صورت بازگشتی
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }


    /*
    |--------------------------------------------------------------------------
    | Translations
    |--------------------------------------------------------------------------
    */

    /**
     * تمام ترجمه‌های دسته
     *
     * fa
     * en
     * ar
     */
    public function translations(): HasMany
    {
        return $this->hasMany(
            CategoryTranslation::class,
            'category_id'
        );
    }


    /**
     * دریافت ترجمه بر اساس زبان
     *
     * مثال:
     *
     * $category->translation('fa')
     * $category->translation('en')
     * $category->translation('ar')
     */
    public function translation(string $locale): ?CategoryTranslation
    {
        return $this->translations
            ->firstWhere('locale', $locale);
    }


    /**
     * ترجمه فارسی
     */
    public function fa(): HasOne
    {
        return $this->hasOne(
            CategoryTranslation::class,
            'category_id'
        )->where('locale', 'fa');
    }


    /**
     * ترجمه انگلیسی
     */
    public function en(): HasOne
    {
        return $this->hasOne(
            CategoryTranslation::class,
            'category_id'
        )->where('locale', 'en');
    }


    /**
     * ترجمه عربی
     */
    public function ar(): HasOne
    {
        return $this->hasOne(
            CategoryTranslation::class,
            'category_id'
        )->where('locale', 'ar');
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * فقط دسته‌های فعال
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }


    /**
     * فقط دسته‌های غیرفعال
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }


    /**
     * فقط دسته‌های ویژه
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }


    /**
     * فقط دسته‌های عادی
     */
    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', false);
    }


    /**
     * فقط دسته‌های سطح اول
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }


    /**
     * فقط زیر دسته‌ها
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }


    /**
     * مرتب‌سازی بر اساس ترتیب
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }


    /**
     * فیلتر بر اساس گروه محصول
     */
    public function scopeForGroup($query, int $groupId)
    {
        return $query->where(
            'product_group_id',
            $groupId
        );
    }


    /**
     * فیلتر بر اساس دسته والد
     */
    public function scopeForParent($query, ?int $parentId)
    {
        if ($parentId === null) {
            return $query->whereNull('parent_id');
        }

        return $query->where(
            'parent_id',
            $parentId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * آیا دسته فعال است؟
     */
    public function isActive(): bool
    {
        return (bool) $this->status;
    }


    /**
     * آیا دسته ویژه است؟
     */
    public function isFeatured(): bool
    {
        return (bool) $this->is_featured;
    }


    /**
     * آیا دسته اصلی است؟
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }


    /**
     * آیا دسته دارای زیر دسته است؟
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }


    /**
     * دریافت نام دسته در زبان مشخص
     *
     * در صورت نبود ترجمه، مقدار پیش‌فرض برگردانده می‌شود.
     */
    public function translatedName(
        string $locale = 'fa',
        string $fallback = '-'
    ): string {
        return $this->translation($locale)?->name
            ?? $fallback;
    }


    /**
     * دریافت slug ترجمه شده
     */
    public function translatedSlug(
        string $locale = 'fa',
        string $fallback = ''
    ): string {
        return $this->translation($locale)?->slug
            ?? $fallback;
    }
}
