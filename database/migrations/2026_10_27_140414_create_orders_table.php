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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | شماره سفارش و ارتباطات
            |--------------------------------------------------------------------------
            */

            // شماره سفارش مانند ORD-2026-000123
            $table->string('order_number', 30)->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // هر سبد فقط یک سفارش
            $table->foreignId('cart_id')
                ->nullable()
                ->unique()
                ->constrained('carts')
                ->nullOnDelete();

            // کد رهگیری سفارش
            $table->string('tracking_code', 20)->unique();

            /*
            |--------------------------------------------------------------------------
            | اطلاعات مشتری
            |--------------------------------------------------------------------------
            */

            $table->string('customer_name', 150);

            $table->string('customer_phone', 20);

            $table->string('customer_email', 150)->nullable();

            /*
            |--------------------------------------------------------------------------
            | اطلاعات ارسال
            |--------------------------------------------------------------------------
            */

            $table->text('shipping_address');

            $table->string('postal_code', 10)->nullable();

            $table->string('city', 100);

            $table->string('province', 100);

            $table->string('shipping_method', 50)->nullable();

            $table->string('shipping_tracking_code', 50)->nullable();

            $table->timestamp('shipped_at')->nullable();

            $table->timestamp('delivered_at')->nullable();

            $table->timestamp('cancelled_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | مبالغ سفارش
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('subtotal')->default(0);

            $table->unsignedBigInteger('shipping_cost')->default(0);

            $table->unsignedBigInteger('discount')->default(0);

            $table->unsignedBigInteger('total_amount')->default(0);

            /*
            |--------------------------------------------------------------------------
            | روش پرداخت
            |--------------------------------------------------------------------------
            */

            $table->enum('payment_method', [
                'online',
                'cod',
                'wallet',
            ])->default('online');

            /*
            |--------------------------------------------------------------------------
            | وضعیت سفارش
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'refunded',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | مدیریت و تاریخچه سفارش
            |--------------------------------------------------------------------------
            */

            // یادداشت داخلی مدیر
            $table->text('admin_note')->nullable();

            // تاریخچه تغییر وضعیت
            $table->json('status_history')->nullable();

            // آخرین مدیر ویرایش‌کننده سفارش
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | زمان‌بندی و ایندکس‌ها
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();

            $table->index('customer_phone');

            $table->index('status');

            $table->index('payment_method');

            $table->index(['status', 'created_at']);

            $table->index('shipped_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
