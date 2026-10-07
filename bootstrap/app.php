<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ ثبت alias برای Middleware
        $middleware->alias([
            'setLocale' => \App\Http\Middleware\SetLocal::class,
        ]);

        // ✅ اگر می‌خواهید Middleware روی همه‌ی درخواست‌ها اجرا شود، این را هم اضافه کنید:
        // $middleware->web(append: [
        //     \App\Http\Middleware\SetLocal::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })
    ->create();
