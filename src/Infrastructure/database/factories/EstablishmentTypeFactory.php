<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Models\Establishment\EstablishmentType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class EstablishmentTypeFactory extends AbstractTypeFactory
{
    protected $model = EstablishmentType::class;
}
