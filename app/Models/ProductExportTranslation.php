<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductExportTranslation extends Model
{
    protected $fillable = [
        'product_export_id',
        'locale',
        'name',
        'meta_title',
        'short_description',
        'description',
        'features',
        'packaging_description',
        'meta_keywords',
        'meta_description',
    ];

    public function productExport(): BelongsTo
    {
        return $this->belongsTo(ProductExport::class);
    }
}
