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
        Schema::create('product_group_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_group_id')
                ->constrained('product_groups')
                ->cascadeOnDelete();

            $table->string('locale', 5)->index();   // fa, en, ar

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();

            // سئو
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            // برای هر گروه فقط یک ترجمه در هر زبان
            $table->unique(['product_group_id', 'locale'], 'pg_translations_unique');
            $table->index(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_group_translations');
    }
};
