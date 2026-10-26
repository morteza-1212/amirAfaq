<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        // اعتبارسنجی زبان
        if (! in_array($locale, ['fa', 'en', 'ar'], true)) {
            abort(404);
        }

        // ذخیره زبان در Session
        session(['locale' => $locale]);

        // تنظیم زبان برای درخواست فعلی
        app()->setLocale($locale);

        // دریافت آدرس صفحه قبلی
        $referer = $request->headers->get('referer');

        // مسیر پیش‌فرض
        $path = '/';

        if ($referer) {
            $parsedPath = parse_url($referer, PHP_URL_PATH) ?? '/';

            $segments = array_values(
                array_filter(explode('/', $parsedPath), 'strlen')
            );

            // حذف پیشوند زبان قبلی
            if (
                ! empty($segments)
                && in_array($segments[0], ['fa', 'en', 'ar'], true)
            ) {
                array_shift($segments);
            }

            $path = '/' . implode('/', $segments);
        }

        // انتقال به همان صفحه با زبان جدید
        return redirect("/{$locale}{$path}");
    }
}
