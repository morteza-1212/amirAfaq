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
        Schema::create('product_groups', function (Blueprint $table) {
            $table->id();

            // کد یکتا برای شناسایی گروه
            $table->string('code', 50)
                ->unique();

            // نوع گروه
            $table->enum('type', [
                'agricultural', //کشاورزی
                'industrial',//صنعتی
                'raw_material',//موارد خام
            ])->default('agricultural');

            // تصویر گروه
            $table->string('image')
                ->nullable();

            // آیکون گروه
            $table->string('icon')
                ->nullable();

            // ترتیب نمایش
            $table->unsignedInteger('sort_order')
                ->default(0);

            // وضعیت فعال / غیرفعال
            $table->boolean('status')
                ->default(true);

            // نمایش در بخش گروه‌های ویژه
            $table->boolean('is_featured')
                ->default(false);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_groups');
    }
};
