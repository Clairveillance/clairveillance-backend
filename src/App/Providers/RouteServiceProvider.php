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
    public const HOME = '/home';
    private const API_PATH = 'src/Infrastructure/routes/api/';
    private const WEB_PATH = 'src/Infrastructure/routes/web/';

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function () {

            //  NOTE: Route::middleware('web') must be declared last or it will overwrite all other routes.

            /*
             * Api routes.
             */
            Route::prefix('api')->middleware(['api'])->as('api.')->group(function () {

                /*
                 * Version 1
                 */
                Route::prefix(config('app.api_version'))->as(config('app.api_version') . '.')->group(
                    base_path(self::API_PATH . config('app.api_version') . '.php')
                );
            });

            /*
             * Web routes.
             */
            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path(self::WEB_PATH . config('app.api_version') . '.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
