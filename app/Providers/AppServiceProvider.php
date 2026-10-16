<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\service\FaqSearchService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $locale = app()->getLocale();

            $view->with([
                'locale'      => $locale,
                'homeUrl'     => url($locale),
                'aboutUrl'    => url($locale . '/about'),
                'servicesUrl' => url($locale . '/services'),
                'productsUrl' => url($locale . '/products'),
                'exportUrl'   => url($locale . '/export'),
                'importUrl'   => url($locale . '/import'),
                'blogUrl'     => url($locale . '/blog'),
                'teamUrl'     => url($locale . '/team'),
                'contactUrl'  => url($locale . '/contact'),
            ]);
        });
    }
}
