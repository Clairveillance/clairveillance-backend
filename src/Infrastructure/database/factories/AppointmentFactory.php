<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Models\Appointment\Appointment;
use Database\Factories\Concerns\AbstractAppointmentFactory;

final class AppointmentFactory extends AbstractAppointmentFactory
{
    protected $model = Appointment::class;
}
