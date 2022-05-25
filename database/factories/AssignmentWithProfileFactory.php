<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assignment\AssignmentWithProfile;
use Database\Factories\Concerns\AbstractAssignmentFactory;

final class AssignmentWithProfileFactory extends AbstractAssignmentFactory
{
    protected $model = AssignmentWithProfile::class;
}
