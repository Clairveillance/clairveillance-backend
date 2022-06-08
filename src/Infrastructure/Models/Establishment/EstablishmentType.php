<?php

declare(strict_types=1);

namespace Infrastructure\Models\Establishment;

use Infrastructure\Models\EstablishmentHasProfile\EstablishmentHasProfile;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EstablishmentType extends Model
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

    public function establishments(): HasMany
    {
        return $this->hasMany(
            related: Establishment::class,
            foreignKey: 'establishment_type_uuid',
            localKey: 'uuid'
        );
    }

    public function establishmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: EstablishmentHasProfile::class,
            foreignKey: 'establishment_type_uuid',
            localKey: 'uuid'
        );
    }
}
