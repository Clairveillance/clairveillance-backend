<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assembly\Assembly;
use Database\Factories\Concerns\AbstractAssemblyFactory;

final class AssemblyFactory extends AbstractAssemblyFactory
{
    protected $model = Assembly::class;
}
