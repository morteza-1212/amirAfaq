<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductGroup extends Model
{
    /** @use HasFactory<\Database\Factories\ProductGroupFactory> */
    use HasFactory;
    /** * فیلدهای قابل پر کردن */ protected $fillable = [
        'code',
    'type',
    'image',
    'icon',
    'sort_order',
    'status',
    'is_featured', ];
    /** * تبدیل نوع فیلدها */
    protected function casts(): array { return [ 'status' => 'boolean', 'is_featured' => 'boolean', 'sort_order' => 'integer', ]; }
    /** * ترجمه‌های گروه محصول */
    public function translations(): HasMany
    { return $this->hasMany( ProductGroupTranslation::class, 'product_group_id' ); }
    /** * ترجمه فارسی */
    public function fa(): HasOne
    {
        return $this->hasOne(ProductGroupTranslation::class, 'product_group_id')
            ->where('locale','fa');
    }

    public function en(): HasOne
    {
        return $this->hasOne(ProductGroupTranslation::class, 'product_group_id')
            ->where('locale','en');
    }


    public function ar(): HasOne
    {
        return $this->hasOne(ProductGroupTranslation::class, 'product_group_id')
            ->where('locale','ar');
    }
    public function category()
    {
        return $this->hasMany(Category::class);

    }
}
