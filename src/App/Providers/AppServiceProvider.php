<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Debugbar::disable(); //NOTE

        if (config('app.dblisten') === true) {
            DB::listen(
                fn ($query) =>
                dump([
                    'SQL' => $query->sql,
                    // 'Bindings' => $query->bindings,
                    'Time' => $query->time . 'ms',
                    // 'Connection' => $query->connection,
                    // 'Connection name' => $query->connectionName
                ])
            );
        }
    }

    public function register()
    {
        // $this->app->bind('path.public', function () {
        //     return base_path() . '/src/Interface/public';
        // });
    }
}
