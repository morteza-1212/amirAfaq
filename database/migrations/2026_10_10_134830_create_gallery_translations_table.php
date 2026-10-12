<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gallery_id')
                ->constrained('galleries')
                ->cascadeOnDelete();

            $table->string('locale', 5); // fa, ar, en
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('alt_text')->nullable();

            $table->timestamps();

            // یک ترجمه برای هر زبان
            $table->unique(['gallery_id', 'locale']);

            // slug در هر زبان باید یکتا باشد
            $table->unique(['locale', 'slug']);

            // برای کوئری سریع‌تر
            $table->index(['locale', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_translations');
    }
};
