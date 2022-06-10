<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Appointment\AppointmentType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class AppointmentTypeFactory extends AbstractTypeFactory
{
    protected $model = AppointmentType::class;
}
