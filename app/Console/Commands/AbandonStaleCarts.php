<?php

namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;

class AbandonStaleCarts extends Command
{
    protected $signature = 'carts:abandon-stale
                            {--days=30 : تعداد روزهای عدم فعالیت}';

    protected $description = 'سبدهای خرید غیرفعال را به وضعیت abandoned تغییر می‌دهد';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        if ($days < 1) {
            $this->error('مقدار --days باید حداقل ۱ باشد.');
            return self::FAILURE;
        }

        $count = Cart\Cart::active()
            ->where('last_activity_at', '<', now()->subDays($days))
            ->update(['status' => 'abandoned']);

        $this->info("✅ {$count} سبد رهاشده علامت‌گذاری شد.");

        return self::SUCCESS;
    }
}
