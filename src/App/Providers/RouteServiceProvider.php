<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';
    private const API_PATH = 'src/Infrastructure/routes/api/';
    private const WEB_PATH = 'src/Infrastructure/routes/web/';

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function () {

            /** Api routes. */
            Route::prefix('api')->middleware(['api'])->as('api.')->group(
                fn () =>
                /** Api Version 1 */
                Route::prefix(config('app.api_version'))->as(config('app.api_version') . '.')->group(
                    base_path(self::API_PATH . config('app.api_version') . '.php')
                )
            );

            // NOTE: Web route must be declared last or it will overwrite all other routes.
            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path(self::WEB_PATH . config('app.api_version') . '.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', fn (Request $request) =>
        Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
    }
}
