<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'gallery' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'weight' => 'decimal:3',
        'minimum_order' => 'decimal:3',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranlation::class);
    }

    public function translation(string $locale): ?ProductTranlation
    {
        return $this->translations
            ->firstWhere('locale', $locale);
    }
}
