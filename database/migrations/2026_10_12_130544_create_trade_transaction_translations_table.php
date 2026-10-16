<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_transaction_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trade_transaction_id')
                ->constrained('trade_transactions')
                ->cascadeOnDelete();

            $table->string('locale', 5); // fa / en / ar

            // اطلاعات متنی معامله
            $table->string('title');
            $table->string('product');

            // اطلاعات کشورها
            $table->string('origin_country')->nullable();
            $table->string('destination_country');

            // جزئیات کالا
            $table->string('packaging')->nullable();

            // متن جایگزین تصویر
            $table->string('alt_text')->nullable();

            // اطلاعات تکمیلی
            $table->text('description')->nullable();

            $table->timestamps();

            $table->unique(
                ['trade_transaction_id', 'locale'],
                'trade_transaction_locale_unique'
            );

            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_transaction_translations');
    }
};
