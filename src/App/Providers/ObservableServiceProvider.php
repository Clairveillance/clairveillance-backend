<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\V1\Shared\Observers\ModelHasProfileObserver;
use App\Core\V1\Users\Observers\UserObserver;
use Infrastructure\Eloquent\Models\Appointment\AppointmentHasProfile;
use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;
use Infrastructure\Eloquent\Models\Establishment\EstablishmentHasProfile;
use Infrastructure\Eloquent\Models\User\User;
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
