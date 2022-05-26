<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class EstablishmentWithProfile extends AbstractEstablishment
{
    use HasSlug;
    use HasProfile;

    /** @var string */
    protected $morphClass = 'establishment_with_profile';

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

    public function assemblyEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: Assembly::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyWithProfileEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssemblyWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: Assignment::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentWithProfileEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssignmentWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function establishmentWithProfileAssemblies(): MorphToMany
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

    public function establishmentWithProfileAssembliesWithProfile(): MorphToMany
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
