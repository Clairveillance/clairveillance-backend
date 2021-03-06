<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Assembly;

use Infrastructure\Eloquent\Models\User\User;
use Infrastructure\Eloquent\Models\Assembly\Assembly;
use Infrastructure\Eloquent\Models\Assembly\AssemblyType;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Infrastructure\Eloquent\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class AbstractAssembly extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'assemblies';

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
            related: AssemblyType::class,
            foreignKey: 'assembly_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function assemblables(Model $model): MorphToMany
    {
        return $this->morphedByMany(
            related: $model,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        )->withPivot(
            columns: ['has_profile']
        );
    }

    public function assemblies(): MorphToMany
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

    public function assembliesHasProfile(): MorphToMany
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
        );
    }

    public function newEloquentBuilder($query): CustomQueryBuilder
    {
        return new CustomQueryBuilder(
            query: $query
        );
    }
}
