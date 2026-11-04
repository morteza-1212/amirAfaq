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
        Schema::create('order_items', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | ارتباط با سفارش
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | ارتباط با محصول فروشگاه
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_shop_id')
                ->nullable()
                ->constrained('product_shops')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | اطلاعات محصول در زمان ثبت سفارش (Snapshot)
            |--------------------------------------------------------------------------
            */

            $table->string('product_name', 255);

            $table->string('product_sku', 100)->nullable();

            $table->string('product_image', 255)->nullable();

            /*
            |--------------------------------------------------------------------------
            | قیمت و تعداد
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('unit_price');

            $table->unsignedInteger('quantity')->default(1);

            $table->unsignedBigInteger('total_price');

            // تخفیف اختصاصی این محصول
            $table->unsignedBigInteger('discount')->default(0);

            /*
            |--------------------------------------------------------------------------
            | زمان‌بندی و ایندکس‌ها
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->index('order_id');

            $table->index('product_shop_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
