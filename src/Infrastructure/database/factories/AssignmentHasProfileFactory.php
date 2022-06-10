<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;
use Database\Factories\Concerns\AbstractAssignmentFactory;

final class AssignmentHasProfileFactory extends AbstractAssignmentFactory
{
    protected $model = AssignmentHasProfile::class;
}
