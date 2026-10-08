<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $table = 'buyers';

    protected $fillable = [
        'product',
        'quantity',
        'destination_country',
        'destination_port',
        'packaging',
        'delivery_time',
        'incoterms',
        'payment_terms',
        'company_information',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * اسکوپ برای فیلتر بر اساس وضعیت
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * اسکوپ برای درخواست‌های جدید
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
