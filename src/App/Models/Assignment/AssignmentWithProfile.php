<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\Assignment\AbstractAssignment;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class AssignmentWithProfile extends AbstractAssignment
{
    use HasSlug;
    use HasProfile;

    public function slugSources(): array
    {
        return [
            'source' => 'name',
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

    public function assignmentWithProfileEstablishments(): MorphToMany
    {
        return $this->morphedByMany(
            related: Establishment::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentWithProfileEstablishmentsWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: EstablishmentWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentWithProfileAssemblies(): MorphToMany
    {
        return $this->morphedByMany(
            related: Assembly::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentWithProfileAssembliesWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: AssemblyWithProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
