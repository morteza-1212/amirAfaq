<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    protected $fillable = [
        'slug',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * ترجمه بر اساس locale — بدون کوئری اضافه اگر eager load شده باشد.
     */
    public function translation(?string $locale = null): ?FaqTranslation
    {
        $locale = $locale ?: app()->getLocale();

        // اگر رابطه eager load شده باشد، از حافظه می‌خواند
        if ($this->relationLoaded('translations')) {
            return $this->translations->firstWhere('locale', $locale)
                ?? $this->translations->first();
        }

        // در غیر این صورت، یک کوئری می‌زند
        return $this->translations()
            ->where('locale', $locale)
            ->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')
            ->orderByDesc('id');
    }
}
