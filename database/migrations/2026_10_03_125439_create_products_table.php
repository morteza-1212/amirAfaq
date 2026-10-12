<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // ارتباط با دسته‌بندی
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // کد محصول
            $table->string('code', 100)->unique();

            // نوع محصول
            $table->enum('type', ['export', 'import', 'both'])->default('export');

            // تصویر اصلی
            $table->string('image')->nullable();

            // گالری تصاویر
            $table->json('gallery')->nullable();

            // وضعیت محصول
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')->default(0);

            // وضعیت موجودی
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_request'])->default('on_request');

            // اطلاعات عمومی
            $table->string('unit', 50)->nullable();
            $table->decimal('weight', 12, 3)->nullable();
            $table->string('origin_country', 100)->nullable();
            $table->decimal('minimum_order', 15, 3)->nullable();
            $table->unsignedInteger('preparation_days')->nullable();
            $table->string('sku', 100)->nullable()->unique();

            $table->timestamps();

            $table->index('category_id');
            $table->index('type');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
