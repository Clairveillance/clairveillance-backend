<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Establishment\EstablishmentHasProfile;
use Database\Factories\Concerns\AbstractEstablishmentFactory;

final class EstablishmentHasProfileFactory extends AbstractEstablishmentFactory
{
    protected $model = EstablishmentHasProfile::class;
}
