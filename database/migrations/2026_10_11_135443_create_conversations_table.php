<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            $table->uuid('public_id')->unique();

            $table->string('session_id')->nullable()->index();

            $table->string('visitor_name')->nullable();

            $table->string('visitor_email')->nullable();

            $table->string('visitor_phone')->nullable();

            $table->string('locale', 5)->default('fa');

            $table->string('status')->default('bot');

            $table->string('subject')->nullable();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('last_message_at')->nullable();

            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'last_message_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
