<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /** @var string */
    public const HOME = '/home';

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function () {

            // TODO: Add condition for turning off/on JsonResponse middleware when APP_DEBUG set true/false.
            /** Api routes. */
            Route::prefix('api')->middleware(['api'])->as('api.')->group(
                fn () =>
                /** Api Version 1 */
                Route::prefix(config('app.api_version'))->as(config('app.api_version') . '.')->group(
                    base_path(Application::API_PATH . config('app.api_version') . '.php')
                )
            );

            // NOTE: Web route must be declared last or it will overwrite all other routes.
            /** Web routes. */
            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->group(base_path(Application::WEB_PATH . config('app.api_version') . '.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', fn (Request $request) =>
        Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
    }
}
