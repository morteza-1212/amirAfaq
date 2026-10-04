<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductGroupTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_group_translations';

    protected $fillable = [
        'product_group_id',
        'locale',
        'name',
        'slug',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * گروه محصول
     */
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    /**
     * نام زبان
     */
    public function getLocaleNameAttribute(): string
    {
        return match ($this->locale) {
            'fa' => 'فارسی',
            'en' => 'English',
            'ar' => 'العربية',
            default => $this->locale,
        };
    }

    /**
     * جهت زبان
     */
    public function getDirectionAttribute(): string
    {
        return $this->locale === 'en' ? 'ltr' : 'rtl';
    }

}
