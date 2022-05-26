<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Establishment\Establishment;
use Database\Factories\Concerns\AbstractEstablishmentFactory;

final class EstablishmentFactory extends AbstractEstablishmentFactory
{
    protected $model = Establishment::class;
}
