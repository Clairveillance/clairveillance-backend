<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Assignment\AssignmentType;
use App\Models\Shared\Traits\HasFactory;
use App\Models\Shared\Traits\HasUuid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractAssignment extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'assignments';

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
            related: AssignmentType::class,
            foreignKey: 'assignment_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function assignables(Model $model): MorphToMany
    {
        return $this->morphedByMany(
            related: $model,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignment_uuid',
            relatedPivotKey: 'assignable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        )->withPivot(['has_profile']);
    }

    public function assignments(): MorphToMany
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
        );
    }

    public function assignmentsHasProfile(): MorphToMany
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
        );
    }
}
