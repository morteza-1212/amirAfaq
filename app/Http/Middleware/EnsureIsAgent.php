<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_agent) {
            abort(403, 'شما به پنل پشتیبانی دسترسی ندارید.');
        }

        return $next($request);
    }
}
