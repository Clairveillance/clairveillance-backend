<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const API_PATH = 'src/Infrastructure/routes/api/';
    public const WEB_PATH = 'src/Infrastructure/routes/web/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            /*
             * Api routes.
             */
            Route::prefix('api')->middleware(['api', 'custom.cors'])->as('api.')->group(function () {

                /*
                 * Version 1
                 */
                Route::prefix(env('API_VERSION', env('API_VERSION', 'v1')))->as(env('API_VERSION', env('API_VERSION', 'v1')) . '.')->group(
                    base_path(self::API_PATH . env('API_VERSION', 'v1') . '.php')
                );
            });

            /*
             * Web routes.
             * Route::middleware('web') must be declared last or it will overwrite all other routes.
             */
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path(self::WEB_PATH . env('WEB_VERSION', 'v1') . '.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
