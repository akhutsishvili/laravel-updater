<?php

namespace Demafelix\LaravelUpdater\Middleware;

use Closure;
use Demafelix\LaravelUpdater\Helpers\LaravelUpdaterHelper;

class LaravelUpdaterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the config is published
        if (!is_file(config_path('laravel-updater.php'))) {
            return LaravelUpdaterHelper::sendResponse(400, 'Please publish the laravel-updater config file first.');
        }

        // Check if the token is correct
        if (empty(config('laravel-updater.updater_key')) || !$request->hasHeader(
                config('laravel-updater.header_name')
            ) || $request->header(config('laravel-updater.header_name')) !== config('laravel-updater.updater_key')) {
            return LaravelUpdaterHelper::sendResponse(403, 'Invalid key.');
        }

        // Check if we have a git folder
        if (!is_dir(base_path('.git'))) {
            return LaravelUpdaterHelper::sendResponse(400, 'No git info found.');
        }
        return $next($request);
    }
}
