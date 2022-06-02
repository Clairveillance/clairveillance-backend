<?php

declare(strict_types=1);

namespace App\Models\Shared\Traits;

use App\Models\Appointment\Appointment;
use App\Models\Appointment\AppointmentHasProfile;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAppointables
{
    public function appointables(): MorphToMany
    {
        return $this->morphToMany(
            related: Appointment::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 0);
    }

    public function appointables_has_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: AppointmentHasProfile::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 1);
    }
}
