<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocal
{
    /**
     * ترتیب اولویت زبان:
     *   1. پارامتر locale در URL  ({locale}/about)
     *   2. Session (انتخاب کاربر)
     *   3. زبان پیش‌فرض اپلیکیشن (config/app.php → locale)
     */
    public function handle(Request $request, Closure $next)
    {
        $supported = ['fa', 'en', 'ar'];

        // اولویت ۱: پارامتر locale از URL
        $locale = $request->route('locale');

        // اولویت ۲: Session
        if (! $locale || ! in_array($locale, $supported)) {
            $locale = session('locale');
        }

        // اولویت ۳: fallback به config
        if (! $locale || ! in_array($locale, $supported)) {
            $locale = config('app.locale', 'fa');
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
