<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Establishment\EstablishmentType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class EstablishmentTypeFactory extends AbstractTypeFactory
{
    protected $model = EstablishmentType::class;
}
