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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | شماره پرداخت
            |--------------------------------------------------------------------------
            */

            $table->string('payment_number', 30)->unique();

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
            | اطلاعات تراکنش
            |--------------------------------------------------------------------------
            */

            $table->string('transaction_id')->nullable()->unique();

            $table->unsignedBigInteger('amount');

            $table->enum('currency', [
                'toman',
                'rial',
            ])->default('toman');

            /*
            |--------------------------------------------------------------------------
            | وضعیت پرداخت
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'canceled',
                'refunded',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | اطلاعات درگاه
            |--------------------------------------------------------------------------
            */

            $table->string('gateway')->default('sandbox');

            // پاسخ دریافتی از درگاه پرداخت
            $table->json('gateway_response')->nullable();

            // اطلاعات تکمیلی پرداخت
            $table->json('metadata')->nullable();

            /*
            |--------------------------------------------------------------------------
            | زمان‌های پرداخت
            |--------------------------------------------------------------------------
            */

            $table->timestamp('paid_at')->nullable();

            $table->timestamp('failed_at')->nullable();

            $table->timestamp('refunded_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | مدیران تأیید و بازپرداخت
            |--------------------------------------------------------------------------
            */

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('refunded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | دلیل خطا یا بازپرداخت
            |--------------------------------------------------------------------------
            */

            $table->string('failure_reason', 255)->nullable();

            /*
            |--------------------------------------------------------------------------
            | زمان‌بندی و ایندکس‌ها
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();

            $table->index(
                ['order_id', 'status', 'created_at'],
                'payments_order_status_created_index'
            );

            $table->index('status');

            $table->index('paid_at');

            $table->index('refunded_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
