<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\AssignmentWithProfile\AssignmentWithProfile;
use App\Models\Shared\Concerns\Traits\HasFactory;
use App\Models\Shared\Concerns\Traits\HasUuid;
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

    public function assignmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: AssignmentWithProfile::class,
            foreignKey: 'assignment_type_uuid',
            localKey: 'uuid'
        );
    }
}
