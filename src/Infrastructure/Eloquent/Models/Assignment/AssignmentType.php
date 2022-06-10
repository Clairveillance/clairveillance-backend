<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Assignment;

use Infrastructure\Eloquent\Models\AssignmentHasProfile\AssignmentHasProfile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AssignmentType extends Model
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

    public function assignments(): HasMany
    {
        return $this->hasMany(
            related: Assignment::class,
            foreignKey: 'assignment_type_uuid',
            localKey: 'uuid'
        );
    }

    public function assignmentsHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AssignmentHasProfile::class,
            foreignKey: 'assignment_type_uuid',
            localKey: 'uuid'
        );
    }
}
