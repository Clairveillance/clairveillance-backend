<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\User\User;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasProfile;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class EstablishmentWithProfile extends AbstractEstablishment
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

    public function establishmentEstablishablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: $this::class,
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

    public function establishmentEstablishmentsWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: $this::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
