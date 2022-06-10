<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Database\Factories\Concerns\AbstractAssemblyFactory;

final class AssemblyHasProfileFactory extends AbstractAssemblyFactory
{
    protected $model = AssemblyHasProfile::class;
}
