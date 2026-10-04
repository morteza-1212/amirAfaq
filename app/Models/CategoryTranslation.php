<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryTranslationFactory> */
    use HasFactory;

    /**
     * فیلدهای قابل پر کردن
     */
    protected $fillable = [
        'category_id',
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
     * تبدیل نوع فیلدها
     */
    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
        ];
    }

    /**
     * دسته مربوطه
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
