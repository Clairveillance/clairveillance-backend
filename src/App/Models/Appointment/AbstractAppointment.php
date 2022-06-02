<?php

declare(strict_types=1);

namespace App\Models\Appointment;

use App\Models\Appointment\Appointment;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Appointment\AppointmentType;
use App\Models\Appointment\QueryBuilder\AppointmentQueryBuilder;
use App\Models\Shared\Traits\HasFactory;
use App\Models\Shared\Traits\HasUuid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractAppointment extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'appointments';

    /** @var array<string> */
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'note',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'published_at' => 'datetime',
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
            related: AppointmentType::class,
            foreignKey: 'appointment_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function appointables(Model $model): MorphToMany
    {
        return $this->morphedByMany(
            related: $model,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointment_uuid',
            relatedPivotKey: 'appointable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        )->withPivot(
            columns: ['has_profile']
        );
    }

    public function appointments(): MorphToMany
    {
        return $this->morphToMany(
            related: Appointment::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function appointmentsHasProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: AppointmentHasProfile::class,
            name: 'appointable',
            table: null,
            foreignPivotKey: 'appointable_uuid',
            relatedPivotKey: 'appointment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function newEloquentBuilder($query): AppointmentQueryBuilder
    {
        return new AppointmentQueryBuilder(
            query: $query
        );
    }
}
