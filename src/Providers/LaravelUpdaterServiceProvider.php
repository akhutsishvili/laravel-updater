<?php

namespace Demafelix\LaravelUpdater\Providers;

use Demafelix\LaravelUpdater\Middleware\LaravelUpdaterMiddleware;
use Illuminate\Support\ServiceProvider;

class LaravelUpdaterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the middleware
        $this->app['router']->aliasMiddleware('laravel-updater', LaravelUpdaterMiddleware::class);

        // Set the routes
        require __DIR__ . '/../routes.php';
    }
}
