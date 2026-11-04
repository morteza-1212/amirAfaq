<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

<<<<<<< HEAD
            // صاحب سبد: کاربر یا null (مهمان)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // اگر کاربر حذف شد، سبد حذف نشود

            // توکن یکتا برای مهمان (همیشه تولید می‌شود، حتی برای کاربر)
            $table->string('token', 64)->unique();

            // اطلاعات تماس مهمان (اختیاری - قبل از Checkout پر می‌شود)
=======
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('token', 64)->unique();

>>>>>>> a96f8e3 (complateforCartshoping)
            $table->string('guest_email', 150)->nullable();
            $table->string('guest_phone', 20)->nullable();
            $table->string('guest_name', 150)->nullable();

<<<<<<< HEAD
            // وضعیت سبد
            $table->enum('status', [
                'active',      // در حال خرید
                'converted',   // تبدیل به سفارش شده
                'abandoned',   // رها شده
            ])->default('active');

            // مبالغ (snapshot برای نمایش سریع)
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedInteger('items_count')->default(0);

            // آدرس IP و User-Agent برای امنیت مهمان
=======
            $table->enum('status', ['active', 'converted', 'abandoned'])
                ->default('active');

            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedInteger('items_count')->default(0);

>>>>>>> a96f8e3 (complateforCartshoping)
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->timestamp('last_activity_at')->nullable();
<<<<<<< HEAD
=======
            $table->timestamp('converted_at')->nullable();   // زمان تبدیل به سفارش
            $table->softDeletes();                            // حذف نرم برای ادمین
>>>>>>> a96f8e3 (complateforCartshoping)
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index('last_activity_at');
            $table->index('guest_phone');
<<<<<<< HEAD
=======
            $table->index('deleted_at');                      // فیلتر ادمین
>>>>>>> a96f8e3 (complateforCartshoping)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
