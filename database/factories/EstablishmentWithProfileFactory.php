<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Establishment\EstablishmentWithProfile;
use Database\Factories\Concerns\AbstractEstablishmentFactory;

final class EstablishmentWithProfileFactory extends AbstractEstablishmentFactory
{
    protected $model = EstablishmentWithProfile::class;
}
