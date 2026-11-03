<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();                                           // شناسه پرداخت
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();                              // شناسه سفارش
            $table->string('transaction_id')->nullable()->unique(); // شناسه تراکنش آزمایشی
            $table->unsignedBigInteger('amount');                   // مبلغ پرداخت
            $table->enum('currency', ['toman', 'rial']);            // واحد پول: تومان یا ریال
            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'canceled',
            ])->default('pending');                                 // وضعیت پرداخت
            $table->string('gateway')->default('sandbox');          // نوع درگاه: sandbox
            $table->timestamp('paid_at')->nullable();               // زمان پرداخت
            $table->json('metadata')->nullable();                   // اطلاعات تکمیلی
            $table->timestamps();                                   // تاریخ ایجاد و ویرایش

            // ایندکس برای کوئری successfulPayment در مدل Order
            $table->index(['order_id', 'status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
