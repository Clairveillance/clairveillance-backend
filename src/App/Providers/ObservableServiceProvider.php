<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Observers\ModelHasProfileObserver;
use App\Core\Observers\UserObserver;
use Infrastructure\Models\Appointment\AppointmentHasProfile;
use Infrastructure\Models\Assembly\AssemblyHasProfile;
use Infrastructure\Models\Assignment\AssignmentHasProfile;
use Infrastructure\Models\Establishment\EstablishmentHasProfile;
use Infrastructure\Models\User\User;
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
