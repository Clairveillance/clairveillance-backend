<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Models\Assignment\Assignment;
use Database\Factories\Concerns\AbstractAssignmentFactory;

final class AssignmentFactory extends AbstractAssignmentFactory
{
    protected $model = Assignment::class;
}
