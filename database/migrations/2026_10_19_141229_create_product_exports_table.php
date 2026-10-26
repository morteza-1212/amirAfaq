<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_exports', function (Blueprint $table) {

            $table->id();

            // ارتباط با دسته‌بندی
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // کد یکتای محصول
            $table->string('sku', 100)->nullable()->unique();

            // تصویر اصلی محصول
            $table->string('image')->nullable();

            // گالری تصاویر
            $table->json('gallery')->nullable();

            // نوع محصول
            $table->enum('product_type', [
                'agricultural',
                'food',
                'industrial',
                'petrochemical',
                'mineral',
                'construction',
                'textile',
                'handicraft',
                'other',
            ])->default('other');

            // واحد اندازه‌گیری
            $table->string('unit', 30)->nullable();

            // حداقل مقدار سفارش
            $table->decimal('minimum_order_quantity', 15, 3)
                ->nullable();

            // حداکثر مقدار قابل تأمین
            $table->decimal('maximum_supply_quantity', 15, 3)
                ->nullable();

            // کشور مبدأ
            $table->string('origin_country', 100)->nullable();

            // نوع بسته‌بندی
            $table->string('packaging_type', 150)->nullable();

            // شرایط نگهداری
            $table->string('storage_conditions', 255)->nullable();

            // مدت ماندگاری
            $table->string('shelf_life', 100)->nullable();

            // قابلیت صادرات
            $table->boolean('is_exportable')->default(true);

            // قابلیت عرضه در بازار داخلی
            $table->boolean('is_available_domestic')->default(false);

            // محصول ویژه
            $table->boolean('is_featured')->default(false);

            // وضعیت فعال بودن
            $table->boolean('is_active')->default(true);

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')->default(0);

            // مشخصات فنی
            $table->json('specifications')->nullable();

            $table->timestamps();

            $table->index('product_type');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_exports');
    }
};
