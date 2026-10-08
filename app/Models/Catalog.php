<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = [
        'slug',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];


    /* ========== Relations ========== */

    public function translations()
    {
        return $this->hasMany(
            CatalogTranslation::class,
            'catalog_id'
        );
    }


    /* ========== Scopes ========== */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('id');
    }


    /* ========== Accessors ========== */

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'فعال' : 'غیرفعال';
    }


    /* ========== Route Key ========== */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
