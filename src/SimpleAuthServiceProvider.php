<?php

namespace DavidGut\SimpleAuth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SimpleAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/simple-auth.php', 'simple-auth');

        $this->app->singleton(MethodManager::class, function ($app) {
            return new MethodManager($app);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/simple-auth.php' => config_path('simple-auth.php'),
            ], 'simple-auth-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/simple-auth'),
            ], 'simple-auth-views');

            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/simple-auth'),
            ], 'simple-auth-lang');

            $this->publishes([
                __DIR__ . '/../dist' => public_path('vendor/simple-auth'),
            ], 'simple-auth-assets');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'simple-auth');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'simple-auth');

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        Route::group([
            'middleware' => ['web'],
            'as' => 'simple-auth.',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}
