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
        Schema::create('cart_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cart_id')
                ->constrained('carts')
                ->cascadeOnDelete();

            $table->foreignId('product_shop_id')
                ->nullable()
                ->constrained('product_shops')
                ->nullOnDelete();

            // تعداد محصول
            $table->unsignedInteger('quantity')->default(1);

            // قیمت محصول در زمان اضافه شدن به سبد
            $table->unsignedBigInteger('unit_price')->default(0);

            // قیمت کل محصول در زمان اضافه شدن به سبد
            $table->unsignedBigInteger('total_price')->default(0);

            // نام محصول در زمان خرید (Snapshot)
            $table->string('product_name', 255)->nullable();

            $table->timestamps();

            // جلوگیری از ثبت تکراری یک محصول در یک سبد
            $table->unique(
                ['cart_id', 'product_shop_id'],
                'cart_items_cart_product_unique'
            );

            $table->index('cart_id');
            $table->index('product_shop_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
