<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_tranlations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // fa / en / ar
            $table->string('locale', 5);

            // نام محصول
            $table->string('name');

            // آدرس صفحه محصول
            $table->string('slug');

            // توضیح کوتاه
            $table->text('short_description')->nullable();

            // توضیحات کامل
            $table->longText('description')->nullable();

            // مشخصات محصول
            $table->longText('specifications')->nullable();

            // ویژگی‌های محصول
            $table->longText('features')->nullable();

            // اطلاعات بسته‌بندی
            $table->text('packaging')->nullable();

            // اطلاعات حمل و نقل
            $table->text('shipping_info')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // متن جایگزین تصویر
            $table->string('alt_text')->nullable();

            $table->timestamps();

            // هر محصول در هر زبان فقط یک ترجمه داشته باشد
            $table->unique(
                ['product_id', 'locale'],
                'product_tranlation_product_locale_unique'
            );

            // slug در هر زبان یکتا باشد
            $table->unique(
                ['locale', 'slug'],
                'product_tranlation_locale_slug_unique'
            );

            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_tranlations');
    }
};
