<?php

declare(strict_types=1);

namespace App\Models\Shared\Traits;

use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentHasProfile;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasEstablishables
{
    public function establishables(): MorphToMany
    {
        return $this->morphToMany(
            related: Establishment::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 0);
    }

    public function establishables_has_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: EstablishmentHasProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 1);
    }
}
