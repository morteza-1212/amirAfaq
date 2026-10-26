<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\SetLocal;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ ثبت همه‌ی aliasها در یک جا
        $middleware->alias([
            'setLocale' => SetLocal::class,
            'admin'     => EnsureIsAdmin::class,
        ]);

        // ✅ اگر می‌خواهید SetLocal روی همه‌ی درخواست‌های web اجرا شود،
        // خط زیر را از حالت کامنت خارج کنید:
        // $middleware->web(append: [
        //     SetLocal::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })
    ->create();
