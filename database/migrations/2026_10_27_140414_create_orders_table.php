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

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // کد رهگیری یکتا برای مهمان و کاربر
            $table->string('tracking_code', 20)->unique();

            // اطلاعات تماس (برای مهمان یا snapshot کاربر)
            $table->string('customer_name', 150);
            $table->string('customer_phone', 20);
            $table->string('customer_email', 150)->nullable();

            // آدرس ارسال
            $table->text('shipping_address');
            $table->string('postal_code', 10)->nullable();
            $table->string('city', 100);
            $table->string('province', 100);

            // مبالغ
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total_amount');

            // روش پرداخت (فقط یک بار، بدون after)
            $table->enum('payment_method', ['online', 'cod', 'wallet'])
                ->default('online');

            $table->enum('status', ['pending', 'paid', 'shipped', 'delivered', 'cancelled'])
                ->default('pending');

            $table->timestamps();

            // ایندکس‌ها
            $table->index('customer_phone');
            $table->index('status');
            $table->index('payment_method');
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
