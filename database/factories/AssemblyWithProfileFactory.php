<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assembly\AssemblyWithProfile;
use Database\Factories\Concerns\AbstractAssemblyFactory;

final class AssemblyWithProfileFactory extends AbstractAssemblyFactory
{
    protected $model = AssemblyWithProfile::class;
}
