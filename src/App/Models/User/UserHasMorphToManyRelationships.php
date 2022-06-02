<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Appointment\Appointment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Establishment\Establishment;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Shared\Concerns\Contracts\AssignableInterface;
use App\Models\Shared\Concerns\Contracts\AssemblableInterface;
use App\Models\Shared\Concerns\Contracts\AppointableInterface;
use App\Models\Shared\Concerns\Contracts\EstablishableInterface;

// TODO: Replace this class by traits.
abstract class UserHasMorphToManyRelationships extends Model implements
    AppointableInterface,
    AssemblableInterface,
    AssignableInterface,
    EstablishableInterface
{
    public function getMorphClass(): string
    {
        return $this->morphClass;
    }

    public function appointables(): MorphToMany
    {
        return $this->morphToMany(
            related: Appointment::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 0);
    }

    public function appointables_has_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: AppointmentHasProfile::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 1);
    }

    public function assemblables(): MorphToMany
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
        )->withPivotValue('has_profile', 0);
    }

    public function assemblables_has_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssemblyHasProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        )->withPivotValue('has_profile', 1);
    }

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
