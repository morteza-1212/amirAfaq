<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['fa', 'en', 'ar'];

        // اولویت اول: زبان موجود در URL
        $locale = $request->route('locale');

        // اولویت دوم: زبان ذخیره‌شده در Session
        if (! $locale || ! in_array($locale, $supported, true)) {
            $locale = session('locale');
        }

        // اولویت سوم: زبان پیش‌فرض برنامه
        if (! $locale || ! in_array($locale, $supported, true)) {
            $locale = config('app.locale', 'fa');
        }

        // بررسی نهایی زبان
        if (! in_array($locale, $supported, true)) {
            $locale = 'fa';
        }

        // تنظیم زبان برنامه
        app()->setLocale($locale);

        // ذخیره زبان در Session
        session(['locale' => $locale]);

        // تعیین زبان پیش‌فرض برای تولید URL
        URL::defaults([
            'locale' => $locale,
        ]);

        return $next($request);
    }
}
