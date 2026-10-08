<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogTranslation extends Model
{
    protected $table = 'catalog_translations';

    protected $fillable = [
        'catalog_id',
        'locale',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Catalog relationship
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(
            Catalog::class,
            'catalog_id'
        );
    }


    /**
     * Get file size in MB
     */
    public function getFileSizeInMbAttribute(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        return number_format(
            $this->file_size / 1024 / 1024,
            2
        );
    }


    /**
     * Check if PDF exists
     */
    public function hasFile(): bool
    {
        return !empty($this->file_path);
    }
}
