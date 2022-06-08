<?php

declare(strict_types=1);

namespace Infrastructure\Models\Appointment;

use Infrastructure\Models\Appointment\AbstractAppointment;
use Infrastructure\Models\Profile\Profile;
use Infrastructure\Models\Shared\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class AppointmentHasProfile extends AbstractAppointment
{
    use HasSlug;

    /** @var string */
    protected $morphClass = 'appointment_has_profile';

    public function slugSources(): array
    {
        return [
            'source' => 'name',
        ];
    }

    public function profile(): MorphOne
    {
        return $this->morphOne(
            related: Profile::class,
            name: 'profilable',
            type: 'profilable_type',
            id: 'profilable_uuid',
            localKey: 'uuid'
        );
    }
}
