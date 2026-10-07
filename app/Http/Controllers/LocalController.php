<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        // اعتبارسنجی زبان
        if (! in_array($locale, ['fa', 'en', 'ar'])) {
            abort(404);
        }

        // ذخیره در Session
        session(['locale' => $locale]);

        // تنظیم زبان برای همین درخواست
        app()->setLocale($locale);

        // محاسبه‌ی مسیر قبلی بدون پیشوند زبان
        $referer = $request->headers->get('referer');

        $path = '/';

        if ($referer) {
            $parsedPath = parse_url($referer, PHP_URL_PATH) ?? '/';
            $segments = array_values(array_filter(explode('/', $parsedPath)));

            // اگر اولین سگمنت زبان قبلی بود، حذفش کن
            if (! empty($segments) && in_array($segments[0], ['fa', 'en', 'ar'])) {
                array_shift($segments);
            }

            $path = '/' . implode('/', $segments);
            if ($path === '/') {
                $path = '/';
            }
        }

        // ریدایرکت به همان صفحه با زبان جدید
        return redirect("/{$locale}{$path}");
    }
}
