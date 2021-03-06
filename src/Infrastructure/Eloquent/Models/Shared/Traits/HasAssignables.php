<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Shared\Traits;

use Infrastructure\Eloquent\Models\Assignment\Assignment;
use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAssignables
{
    public function assignables(): MorphToMany
    {
        return $this->morphToMany(
            related: Assignment::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 0);
    }

    public function assignables_has_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssignmentHasProfile::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 1);
    }
}
