<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, ['fa', 'en', 'ar'], true)) {
            abort(404);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
