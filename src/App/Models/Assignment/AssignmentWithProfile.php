<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\User\User;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Assignment\AbstractAssignment;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class AssignmentWithProfile extends AbstractAssignment
{
    use HasSlug;
    use HasProfile;

    public function slugSources(): array
    {
        return [
            'source' => 'name'
        ];
    }

    public function profile(): MorphOne
    {
        return $this->morphOne(
            related: Profile::class,
            name: 'profilable',
            type: 'profilable_type',
            id: 'profilable_uuid',
            localKey: 'uuid'
        );
    }

    public function assignmentAssignablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: $this::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userAssignablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentAssignmentsWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: $this::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignment_uuid',
            relatedPivotKey: 'assignable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
