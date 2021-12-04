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

    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            /*
             * Api routes.
             */
            Route::prefix('api')->middleware(['api', 'cors'])->as('api.')->group(function () {

                /*
                 * Version 1
                 */
                Route::prefix('v1')->as('v1.')->group(
                    base_path('routes/api/v1.php')
                );
            });

            /*
             * Web routes.
             * Route::middleware('web') must be declared last or it will overwrite all other routes.
             */
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
