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
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();

            // دسته مربوطه
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            // زبان: fa / en / ar
            $table->string('locale', 5)->index();

            // نام دسته
            $table->string('name');

            // URL
            $table->string('slug');

            // توضیح کوتاه
            $table->string('short_description', 500)->nullable();

            // توضیحات کامل
            $table->text('description')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            // هر دسته در هر زبان فقط یک ترجمه
            $table->unique(['category_id', 'locale'], 'cat_trans_unique');

            // slug در هر زبان یکتا
            $table->unique(['locale', 'slug'], 'cat_trans_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};
