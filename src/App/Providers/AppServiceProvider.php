<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // NOTE: Not sure if this is necessary.
        // Defining property $morhpClass and method getMorphClass() in the desired Models seems good enough.
        // This approach is even better cause we have more flexibility. We only change the polymorphic type when we need it.
        // But with enforceMorhMap() function we have to fill the arguments array with all the polymorphic relations
        // that are present in our application or the system will break.

        // Relation::enforceMorphMap([
        //     'user' => 'App\Models\User\User',
        //     'post' => 'App\Models\Post\Post',
        //     'profile' => 'App\Models\Profile\Profile',
        //     'assembly' => 'App\Models\Assembly\Assembly',
        //     'assembly_with_profile' => 'App\Models\Assembly\AssemblyWithProfile',
        //     'assignment' => 'App\Models\Assignment\Assignment',
        //     'assignment_with_profile' => 'App\Models\Assignment\AssignmentWithProfile',
        //     'establishment' => 'App\Models\Establishment\Establishment',
        //     'establishment_with_profile' => 'App\Models\Establishment\EstablishmentWithProfile',
        // ]);

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
                    'Time' => $executionTime . 'ms',
                    // 'Connection' => $connection,
                    // 'Connection name' => $connectionName
                ]);
            });
        }
    }
}
