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
        Schema::create('catalog_translations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('catalog_id')
                ->constrained('catalogs')
                ->cascadeOnDelete();

            $table->string('locale', 5);

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->string('file_path')
                ->nullable();

            $table->string('file_name')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'catalog_id',
                'locale'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_translations');
    }
};
