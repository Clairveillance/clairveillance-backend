<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Observers\ModelHasProfileObserver;
use App\Core\Observers\UserObserver;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentWithProfile;
use App\Models\User\User;
use Illuminate\Support\ServiceProvider;

class ObservableServiceProvider extends ServiceProvider
{

    /**
     *
     * @return void
     */
    public function boot()
    {
        User::observe(classes: UserObserver::class);
        AssemblyHasProfile::observe(classes: ModelHasProfileObserver::class);
        AssignmentWithProfile::observe(classes: ModelHasProfileObserver::class);
        EstablishmentWithProfile::observe(classes: ModelHasProfileObserver::class);
    }
}
