<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Appointment;

use Infrastructure\Eloquent\Models\Appointment\Appointment;
use Infrastructure\Eloquent\Models\Appointment\AppointmentHasProfile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AppointmentType extends Model
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

    public function appointments(): HasMany
    {
        return $this->hasMany(
            related: Appointment::class,
            foreignKey: 'appointment_type_uuid',
            localKey: 'uuid'
        );
    }

    public function appointmentsHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AppointmentHasProfile::class,
            foreignKey: 'appointment_type_uuid',
            localKey: 'uuid'
        );
    }
}
