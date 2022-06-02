<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentHasProfile;
use App\Models\Establishment\EstablishmentType;
use App\Models\Post\Post;
use App\Models\Shared\Traits\HasFactory;
use App\Models\Shared\Traits\HasUuid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        )->withPivot(['has_profile']);
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
}
