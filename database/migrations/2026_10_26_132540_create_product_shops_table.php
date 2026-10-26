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
        Schema::create('product_shops', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            // دسته‌بندی محصول
            $table->foreignId('category_shop_id')
                ->constrained('category_shops')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            // نام محصول
            $table->string('name', 200);

            // آدرس اختصاصی محصول
            $table->string('slug', 220)->unique();

            // کد محصول
            $table->string('sku', 100)->unique();

            // توضیح کوتاه
            $table->string('short_description', 500)->nullable();

            // توضیحات کامل
            $table->longText('description')->nullable();

            // برند محصول
            $table->string('brand', 150)->nullable();

            // کشور سازنده یا مبدأ
            $table->string('country_of_origin', 100)->nullable();

            // نوع محصول: فیزیکی یا مجازی
            $table->enum('product_type', [
                'physical',
                'digital',
            ])->default('physical');

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            // قیمت فروش به تومان
            $table->unsignedBigInteger('price');

            // قیمت قبل از تخفیف
            $table->unsignedBigInteger('compare_price')->nullable();

            // قیمت تمام‌شده، اختیاری
            $table->unsignedBigInteger('cost_price')->nullable();

            // درصد مالیات، در صورت نیاز
            $table->decimal('tax_rate', 5, 2)->default(0);

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            // مدیریت موجودی فعال است؟
            $table->boolean('manage_stock')->default(true);

            // تعداد موجودی
            $table->unsignedInteger('stock_quantity')->default(0);

            // حداقل موجودی برای هشدار
            $table->unsignedInteger('low_stock_threshold')->default(5);

            // امکان پیش‌خرید
            $table->boolean('allow_backorder')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Physical Product Information
            |--------------------------------------------------------------------------
            */

            // وزن بر حسب گرم
            $table->unsignedInteger('weight')->nullable();

            // طول بر حسب میلی‌متر
            $table->unsignedInteger('length')->nullable();

            // عرض بر حسب میلی‌متر
            $table->unsignedInteger('width')->nullable();

            // ارتفاع بر حسب میلی‌متر
            $table->unsignedInteger('height')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            // تصویر اصلی محصول
            $table->string('image')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            // وضعیت محصول
            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            // نمایش در صفحه اصلی
            $table->boolean('is_featured')->default(false);

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')->default(0);

            // زمان انتشار
            $table->timestamp('published_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            // عنوان سئو
            $table->string('meta_title', 255)->nullable();

            // توضیحات سئو
            $table->string('meta_description', 500)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('category_shop_id');
            $table->index('status');
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index('published_at');
            $table->index(['status', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shops');
    }
};
