<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns\Abstractions;

use App\Models\Assembly\Assembly;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assembly\AssemblyWithProfile;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Shared\Concerns\Interfaces\AssemblableInterface;

abstract class AbstractAssemblableModel extends Model implements AssemblableInterface
{
    public function getMorphClass(): string
    {
        return $this->morphClass;
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
        );
    }

    public function assemblables_with_profile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssemblyWithProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }
}
