<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_transactions', function (Blueprint $table) {
            $table->id();

            // کد یکتای معامله (خودکار ساخته می‌شود)
            $table->string('transaction_code', 50)->nullable()->unique();

            // نوع معامله: صادرات یا واردات
            $table->enum('transaction_type', ['export', 'import'])
                ->default('export');

            // تصویر معامله
            $table->string('image')->nullable();

            // مقدار و واحد کالا
            $table->decimal('quantity', 18, 3)->nullable();
            $table->string('unit', 20)->default('ton');

            // روش حمل
            $table->enum('transport_method', ['sea', 'air', 'land'])
                ->nullable();

            // زمان تحویل
            $table->string('delivery_time')->nullable();

            // تاریخ‌های معامله
            $table->date('contract_date')->nullable();
            $table->date('delivery_date')->nullable();

            // ترتیب نمایش و وضعیت انتشار
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_type');
            $table->index('is_published');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_transactions');
    }
};
