<?php

declare(strict_types=1);

namespace Infrastructure\Models\Assembly;

use Infrastructure\Models\AssemblyHasProfile\AssemblyHasProfile;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AssemblyType extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function assemblies(): HasMany
    {
        return $this->hasMany(
            related: Assembly::class,
            foreignKey: 'assembly_type_uuid',
            localKey: 'uuid'
        );
    }

    public function assembliesHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AssemblyHasProfile::class,
            foreignKey: 'assembly_type_uuid',
            localKey: 'uuid'
        );
    }
}
