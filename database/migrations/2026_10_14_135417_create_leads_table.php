<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('conversation_id')
                ->unique()
                ->constrained('conversations')
                ->cascadeOnDelete();

            $table->string('lead_type')->default('inquiry');

            $table->string('name')->nullable();

            $table->string('company_name')->nullable();

            $table->string('email')->nullable();

            $table->string('phone')->nullable();

            $table->string('product')->nullable();

            $table->decimal('quantity', 15, 3)->nullable();

            $table->string('unit', 30)->nullable();

            $table->string('destination_country')->nullable();

            $table->string('destination_port')->nullable();

            $table->string('packaging')->nullable();

            $table->string('incoterms', 3)->nullable();

            $table->string('payment_terms')->nullable();

            $table->text('delivery_time')->nullable();

            $table->text('description')->nullable();

            $table->string('status')->default('new');

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
