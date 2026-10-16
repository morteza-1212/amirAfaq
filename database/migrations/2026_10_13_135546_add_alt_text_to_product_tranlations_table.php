<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ فقط اگر ستون وجود ندارد، اضافه کن
        if (! Schema::hasColumn('product_tranlations', 'alt_text')) {
            Schema::table('product_tranlations', function (Blueprint $table) {
                $table->string('alt_text')->nullable()->after('meta_keywords');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('product_tranlations', 'alt_text')) {
            Schema::table('product_tranlations', function (Blueprint $table) {
                $table->dropColumn('alt_text');
            });
        }
    }
};
