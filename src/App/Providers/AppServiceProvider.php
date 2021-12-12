<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if (config('app.dblisten') === true) {
            DB::listen(function ($query) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $executionTime = $query->time;
                $connection = $query->connection;
                $connectionName = $query->connectionName;

                dump([
                    'SQL' => $sql,
                    // 'Bindings' => $bindings,
                    'Time' => $executionTime.'ms',
                    // 'Connection' => $connection,
                    // 'Connection name' => $connectionName
                ]);
            });
        }
    }
}
