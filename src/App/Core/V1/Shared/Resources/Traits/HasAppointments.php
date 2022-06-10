<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use App\Core\V1\Shared\Resources\Traits\HasType;
use Illuminate\Http\Resources\Json\JsonResource;
use Infrastructure\Models\Appointment\Appointment;
use App\Core\V1\Shared\Resources\Traits\HasProfile;
use Infrastructure\Models\Appointment\AppointmentHasProfile;

trait HasAppointments
{
    use HasType;
    use HasLinks;
    use HasProfile;
    use FormatDates;

    public function appointments(JsonResource $resource, string $name): array
    {
        return [
            'appointments_count' => $resource->appointables_count ?? null,
            'appointments' =>
            $resource->relationLoaded('appointables') ?
                $resource->appointables
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (Appointment $appointable) =>
                    collect([
                        'uuid' => $appointable->uuid,
                        'name' => $appointable->name,
                        'description' => $appointable->description,
                        'note' => $appointable->note,
                        'start_at' => $this::dateTimeToString($appointable->start_at),
                        'end_at' => $this::dateTimeToString($appointable->end_at),
                        'published_at' => $this::dateTimeToString($appointable->published_at),
                        'likes_count' => $appointable->likes_count,
                        'dislikes_count' => $appointable->dislikes_count,
                        'type'  => $this->type($appointable, 'appointments'),
                    ])
                ) : null,
        ];
    }

    public function appointments_has_profile(JsonResource $resource, string $name): array
    {
        return [
            'appointments_has_profile_count' => $resource->appointables_has_profile_count ?? null,
            'appointments_has_profile' =>
            $resource->relationLoaded('appointables_has_profile') ?
                $resource->appointables_has_profile
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (AppointmentHasProfile $appointable) =>
                    collect([
                        'uuid' => $appointable->uuid,
                        'name' => $appointable->name,
                        'slug' => $appointable->slug,
                        'description' => $appointable->description,
                        'note' => $appointable->note,
                        'start_at' => $this::dateTimeToString($appointable->start_at),
                        'end_at' => $this::dateTimeToString($appointable->end_at),
                        'published_at' => $this::dateTimeToString($appointable->published_at),
                        'profile'  => $this->profile($appointable, 'appointments'),
                        'type'  => $this->type($appointable, 'appointments'),
                    ])
                ) : null,
        ];
    }
}
