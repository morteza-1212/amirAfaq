<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_shop_images', function (Blueprint $table) {
            $table->id();

            // ارتباط با محصول
            $table->foreignId('product_shop_id')
                ->constrained('product_shops')
                ->cascadeOnDelete();

            // مسیر تصویر
            $table->string('image_path');

            // متن جایگزین تصویر برای دسترس‌پذیری و سئو
            $table->string('alt_text', 255)->nullable();

            // ترتیب نمایش تصویر
            $table->unsignedInteger('sort_order')->default(0);

            // آیا این تصویر، تصویر اصلی محصول است؟
            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            // ایندکس‌ها
            $table->index('product_shop_id');
            $table->index(['product_shop_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shop_images');
    }
};
