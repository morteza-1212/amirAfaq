<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_export_translations', function (Blueprint $table) {

            $table->id();

            // ارتباط با محصول
            $table->foreignId('product_export_id')
                ->constrained('product_exports')
                ->cascadeOnDelete();

            // زبان ترجمه
            $table->string('locale', 5);

            // نام محصول
            $table->string('name');

            // عنوان سئو
            $table->string('meta_title')->nullable();

            // توضیحات کوتاه
            $table->string('short_description', 500)->nullable();

            // توضیحات کامل
            $table->longText('description')->nullable();

            // ویژگی‌های محصول
            $table->longText('features')->nullable();

            // توضیحات بسته‌بندی
            $table->text('packaging_description')->nullable();

            // کلمات کلیدی سئو
            $table->text('meta_keywords')->nullable();

            // توضیحات متا
            $table->text('meta_description')->nullable();

            $table->timestamps();

            // هر محصول در هر زبان فقط یک ترجمه دارد
            $table->unique(
                ['product_export_id', 'locale'],
                'product_export_translation_locale_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_export_translations');
    }
};
