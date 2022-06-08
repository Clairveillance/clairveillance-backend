<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Support\FormatDate;
use App\Models\Appointment\Appointment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Appointment\AppointmentHasProfile;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Core\Resources\Api\V1\Shared\Traits\HasProfile;

trait HasAppointments
{
    use HasType;
    use HasLinks;
    use HasProfile;

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
                        'start_at' => FormatDate::humanizeYmdHis($appointable->start_at),
                        'end_at' => FormatDate::humanizeYmdHis($appointable->end_at),
                        'published_at' => FormatDate::humanizeYmdHis($appointable->published_at),
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
                        'start_at' => FormatDate::humanizeYmdHis($appointable->start_at),
                        'end_at' => FormatDate::humanizeYmdHis($appointable->end_at),
                        'published_at' => FormatDate::humanizeYmdHis($appointable->published_at),
                        'profile'  => $this->profile($appointable, 'appointments'),
                        'type'  => $this->type($appointable, 'appointments'),
                    ])
                ) : null,
        ];
    }
}
