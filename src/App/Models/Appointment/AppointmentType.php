<?php

declare(strict_types=1);

namespace App\Models\Appointment;

use App\Models\AppointmentWithProfile\AppointmentWithProfile;
use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
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

    public function appointmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: AppointmentWithProfile::class,
            foreignKey: 'appointment_type_uuid',
            localKey: 'uuid'
        );
    }
}