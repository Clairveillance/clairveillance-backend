<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Appointment;

use Infrastructure\Eloquent\Models\Appointment\AbstractAppointment;
use Infrastructure\Eloquent\Models\Profile\Profile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasSlug;
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
