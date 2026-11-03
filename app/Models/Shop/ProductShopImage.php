<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductShopImage extends Model
{
    use HasFactory;

    protected $table = 'product_shop_images';

    protected $fillable = [
        'product_shop_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(ProductShop::class, 'product_shop_id');
    }
}
