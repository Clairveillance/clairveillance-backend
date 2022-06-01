<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Observers\ModelHasProfileObserver;
use App\Core\Observers\UserObserver;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;
use App\Models\User\User;
use Illuminate\Support\ServiceProvider;

class ObservableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        User::observe(classes: UserObserver::class);
        AssemblyHasProfile::observe(classes: ModelHasProfileObserver::class);
        AssignmentHasProfile::observe(classes: ModelHasProfileObserver::class);
        AppointmentHasProfile::observe(classes: ModelHasProfileObserver::class);
        EstablishmentHasProfile::observe(classes: ModelHasProfileObserver::class);
    }
}
