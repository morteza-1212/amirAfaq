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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();

            // Product Information
            $table->string('product');
            $table->string('quantity');

            // Destination
            $table->string('destination_country');
            $table->string('destination_port')->nullable();

            // Packaging
            $table->string('packaging')->nullable();

            // Delivery & Terms
            $table->string('delivery_time')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('payment_terms')->nullable();

            // Company Information
            $table->text('company_information');

            // Contact Information
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Additional Message
            $table->text('message')->nullable();

            // Status (اختیاری - برای مدیریت درخواست‌ها در پنل ادمین)
            $table->enum('status', ['new', 'reviewed', 'contacted', 'closed'])
                ->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
