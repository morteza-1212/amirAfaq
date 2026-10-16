<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // بررسی ورود کاربر
        if (! auth()->check()) {
            // هدایت به صفحه ورود با زبان فعلی
            $locale = $request->route('locale')
                ?? session('locale')
                ?? config('app.locale', 'fa');

            return redirect()->route('login', [
                'locale' => $locale,
            ]);
        }

        // بررسی نقش ادمین
        if (auth()->user()->role !== 'admin') {
            abort(403, 'شما اجازه دسترسی به پنل مدیریت را ندارید.');
        }

        return $next($request);
    }
}
