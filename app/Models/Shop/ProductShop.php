<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductShop extends Model
{
    use HasFactory;

    protected $table = 'product_shops';

    protected $fillable = [
        'category_shop_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'brand',
        'country_of_origin',
        'product_type',
        'price',
        'compare_price',
        'cost_price',
        'tax_rate',
        'manage_stock',
        'stock_quantity',
        'low_stock_threshold',
        'allow_backorder',
        'weight',
        'length',
        'width',
        'height',
        'image',
        'status',
        'is_featured',
        'sort_order',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price'               => 'integer',
        'compare_price'       => 'integer',
        'cost_price'          => 'integer',
        'tax_rate'            => 'float',
        'manage_stock'        => 'boolean',
        'stock_quantity'      => 'integer',
        'low_stock_threshold' => 'integer',
        'allow_backorder'     => 'boolean',
        'weight'              => 'integer',
        'length'              => 'integer',
        'width'               => 'integer',
        'height'              => 'integer',
        'is_featured'         => 'boolean',
        'sort_order'          => 'integer',
        'published_at'        => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function categoryShop(): BelongsTo
    {
        return $this->belongsTo(CategoryShop::class, 'category_shop_id');
    }

    /**
     * نام مستعار برای راحتی (category)
     */
    public function category(): BelongsTo
    {
        return $this->categoryShop();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductShopImage::class, 'product_shop_id')
            ->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductShopImage::class, 'product_shop_id')
            ->where('is_primary', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * فقط محصولات منتشرشده و زمان انتشارشان فرا رسیده باشد
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function (Builder $q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * فقط محصولات ویژه
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * فقط محصولات موجود (یا قابل پیش‌خرید)
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('manage_stock', false)
                ->orWhere('stock_quantity', '>', 0)
                ->orWhere('allow_backorder', true);
        });
    }

    /**
     * فیلتر بر اساس دسته‌بندی
     */
    public function scopeInCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_shop_id', $categoryId);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * آیا محصول منتشر شده و آماده نمایش است؟
     */
    public function isPublished(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        return $this->published_at === null || $this->published_at->isPast();
    }

    /**
     * آیا محصول قابل خرید است؟
     */
    public function isPurchasable(): bool
    {
        if (! $this->isPublished()) {
            return false;
        }

        if (! $this->manage_stock) {
            return true;
        }

        return $this->stock_quantity > 0 || $this->allow_backorder;
    }

    /**
     * آیا موجودی کم است؟
     */
    public function isLowStock(): bool
    {
        if (! $this->manage_stock) {
            return false;
        }

        return $this->stock_quantity > 0
            && $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * آیا ناموجود است؟
     */
    public function isOutOfStock(): bool
    {
        if (! $this->manage_stock) {
            return false;
        }

        return $this->stock_quantity <= 0 && ! $this->allow_backorder;
    }

    /**
     * درصد تخفیف (یا null اگر تخفیف ندارد)
     */
    public function discountPercent(): ?int
    {
        if (! $this->compare_price || $this->compare_price <= $this->price) {
            return null;
        }

        return (int) round(
            (($this->compare_price - $this->price) / $this->compare_price) * 100
        );
    }

    /**
     * مبلغ تخفیف
     */
    public function discountAmount(): int
    {
        if (! $this->compare_price || $this->compare_price <= $this->price) {
            return 0;
        }

        return $this->compare_price - $this->price;
    }

    /**
     * آیا این محصول فیزیکی است؟
     */
    public function isPhysical(): bool
    {
        return $this->product_type === 'physical';
    }

    /**
     * آیا این محصول دیجیتال است؟
     */
    public function isDigital(): bool
    {
        return $this->product_type === 'digital';
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (دسترسی‌های اضافی)
    |--------------------------------------------------------------------------
    */

    /**
     * قیمت با احتساب مالیات
     */
    public function getPriceWithTaxAttribute(): int
    {
        return (int) round($this->price * (1 + ($this->tax_rate / 100)));
    }

    /**
     * آدرس کامل تصویر اصلی
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        // اگر آدرس کامل است، دست نزن
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    */

    /**
     * مسیر پیش‌فرض برای route model binding (به جای id از slug استفاده کن)
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
