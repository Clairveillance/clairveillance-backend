<?php

declare(strict_types=1);

namespace Infrastructure\Models\Establishment;

use Infrastructure\Models\User\User;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Establishment\Establishment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\Establishment\EstablishmentType;
use Infrastructure\Models\Establishment\EstablishmentHasProfile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Infrastructure\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class AbstractEstablishment extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'establishments';

    /** @var array<string> */
    protected $fillable = [
        'name',
        'description',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
    ];

    public function getMorphClass(): string
    {
        return $this->morphClass;
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            related: EstablishmentType::class,
            foreignKey: 'establishment_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function establishables(Model $model): MorphToMany
    {
        return $this->morphedByMany(
            related: $model,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        )->withPivot(
            columns: ['has_profile']
        );
    }

    public function establishments(): MorphToMany
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
        );
    }

    public function establishmentsHasProfile(): MorphToMany
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
        );
    }

    public function newEloquentBuilder($query): CustomQueryBuilder
    {
        return new CustomQueryBuilder(
            query: $query
        );
    }
}
