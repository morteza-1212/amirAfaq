<?php

namespace App\Models\Shop;

use App\Support\PersianSlugger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ParentCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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

    protected $appends = ['image_url'];

    /* -----------------------------------------------------------------
     |  Boot / Events
     | ----------------------------------------------------------------- */

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name);
            } else {
                $model->slug = static::generateUniqueSlug($model->slug, null, true);
            }
        });

        static::updating(function (self $model) {
            if (empty($model->slug) && $model->isDirty('name')) {
                $model->slug = static::generateUniqueSlug($model->name, $model->id);
            } elseif ($model->isDirty('slug') && ! empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->slug, $model->id, true);
            }
        });
    }

    /* -----------------------------------------------------------------
     |  Accessors
     | ----------------------------------------------------------------- */

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : asset('storage/' . ltrim($this->image, '/'));
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | ----------------------------------------------------------------- */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('slug', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    /* -----------------------------------------------------------------
     |  Slug Helper
     | ----------------------------------------------------------------- */

    /**
     * ساخت اسلاگ یکتا از نام (با پشتیبانی کامل از فارسی)
     *
     * @param  string    $name      ورودی خام (فارسی یا انگلیسی)
     * @param  int|null  $ignoreId  در حالت ویرایش، آیدی خودِ رکورد
     * @param  bool      $rawIsSlug اگر true، ورودی از قبل اسلاگ است (دستی)
     */
    public static function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null,
        bool $rawIsSlug = false
    ): string {
        $base = $rawIsSlug
            ? Str::slug($name, '-')
            : PersianSlugger::make($name);

        if ($base === '') {
            $base = 'category';
        }

        $slug = $base;
        $i    = 1;

        while (
        static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
