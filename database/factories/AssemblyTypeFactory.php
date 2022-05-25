<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assembly\AssemblyType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class AssemblyTypeFactory extends AbstractTypeFactory
{
    protected $model = AssemblyType::class;
}
