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
                ->constrained('product_shops')
                ->cascadeOnDelete();

            $table->unsignedInteger('quantity')->default(1);

            // snapshot قیمت
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('total_price');

            $table->timestamps();

            $table->unique(['cart_id', 'product_shop_id']);
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
