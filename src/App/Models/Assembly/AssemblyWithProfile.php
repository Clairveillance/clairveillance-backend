<?php

declare(strict_types=1);

namespace App\Models\Assembly;

use App\Models\Assembly\Assembly;
use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentWithProfile;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class AssemblyWithProfile extends AbstractAssembly
{
    use HasSlug;
    use HasProfile;

    protected function slugSources(): array
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

    public function assemblyWithProfileAssemblables(): MorphToMany
    {
        return $this->morphToMany(
            related: Assembly::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyWithProfileAssemblablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: $this::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userAssemblablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyWithProfileAssemblies(): MorphToMany
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

    public function assemblyWithProfileAssembliesWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: $this::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assemblyWithProfileEstablishments(): MorphToMany
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

    public function assemblyWithProfileEstablishmentsWithProfile(): MorphToMany
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
}
