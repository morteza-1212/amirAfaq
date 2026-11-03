<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryShop extends Model
{
    use HasFactory;

    protected $table = 'category_shops';

    protected $fillable = [
        'parent_category_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(CategoryShop::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CategoryShop::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(ProductShop::class, 'category_shop_id');
    }
}
