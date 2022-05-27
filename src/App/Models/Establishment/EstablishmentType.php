<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\EstablishmentWithProfile\EstablishmentWithProfile;
use App\Models\Shared\Concerns\Traits\HasFactory;
use App\Models\Shared\Concerns\Traits\HasUuid;
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
            related: EstablishmentWithProfile::class,
            foreignKey: 'establishment_type_uuid',
            localKey: 'uuid'
        );
    }
}
