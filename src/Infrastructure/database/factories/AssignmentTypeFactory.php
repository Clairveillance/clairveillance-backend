<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Assignment\AssignmentType;
use Database\Factories\Concerns\AbstractTypeFactory;

final class AssignmentTypeFactory extends AbstractTypeFactory
{
    protected $model = AssignmentType::class;
}
