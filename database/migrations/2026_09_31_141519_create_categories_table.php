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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // گروه محصول
            $table->foreignId('product_group_id')
                ->constrained('product_groups')
                ->cascadeOnDelete();

            // دسته والد (برای دسته‌های سطح اول NULL است)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // کد یکتا برای دسته
            $table->string('code', 50)->unique();

            // تصویر دسته
            $table->string('image')->nullable();

            // آیکون دسته
            $table->string('icon')->nullable();

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')->default(0);

            // فعال / غیرفعال
            $table->boolean('status')->default(true);

            // نمایش در دسته‌های ویژه
            $table->boolean('is_featured')->default(false);

            $table->timestamps();

            // ایندکس برای جستجو و روابط
            $table->index('product_group_id');
            $table->index('parent_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
