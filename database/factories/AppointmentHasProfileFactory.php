<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Appointment\AppointmentHasProfile;
use Database\Factories\Concerns\AbstractAppointmentFactory;

final class AppointmentHasProfileFactory extends AbstractAppointmentFactory
{
    protected $model = AppointmentHasProfile::class;
}
