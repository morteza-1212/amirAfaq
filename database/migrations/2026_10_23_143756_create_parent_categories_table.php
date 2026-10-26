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
        Schema::create('parent_categories', function (Blueprint $table) {
            $table->id();

            // نام دسته‌بندی اصلی
            $table->string('name', 150);

            // آدرس اختصاصی دسته‌بندی
            $table->string('slug', 180)->unique();

            // توضیحات دسته‌بندی
            $table->text('description')->nullable();

            // تصویر دسته‌بندی
            $table->string('image')->nullable();

            // آیکون دسته‌بندی
            $table->string('icon', 100)->nullable();

            // عنوان سئو
            $table->string('meta_title', 255)->nullable();

            // توضیحات سئو
            $table->string('meta_description', 500)->nullable();

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')->default(0);

            // وضعیت فعال یا غیرفعال
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // ایندکس برای جستجو و فیلتر
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_categories');
    }
};
