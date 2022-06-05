<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Appointment\Appointment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Appointment\AppointmentHasProfile;

trait HasAppointments
{
    public function appointments(JsonResource $resource): array
    {
        return [
            'appointments_count' =>
            $resource->relationLoaded('appointables') ?
                $resource->appointables_count : null,
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
                        'start_at' => $this->getFormattedDate($appointable->start_at),
                        'end_at' => $this->getFormattedDate($appointable->end_at),
                        'published_at' => $this->getFormattedDate($appointable->published_at),
                        'type_uuid' => $appointable->relationLoaded('type') ?
                            $appointable->type->uuid : null,
                        'type_name' => $appointable->relationLoaded('type') ?
                            $appointable->type->name : null,
                        'likes_count' => $appointable->likes_count,
                        'dislikes_count' => $appointable->dislikes_count,
                    ])
                ) : null,
        ];
    }

    public function appointments_has_profile(JsonResource $resource): array
    {
        return [
            'appointments_has_profile_count' =>
            $resource->relationLoaded('appointables_has_profile') ?
                $resource->appointables_has_profile_count : null,
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
                        'start_at' => $this->getFormattedDate($appointable->start_at),
                        'end_at' => $this->getFormattedDate($appointable->end_at),
                        'published_at' => $this->getFormattedDate($appointable->published_at),
                        'type_uuid' => $appointable->relationLoaded('type') ?
                            $appointable->type->uuid : null,
                        'type_name' => $appointable->relationLoaded('type') ?
                            $appointable->type->name : null,
                        'profile_uuid' => $appointable->relationLoaded('profile') ?
                            $appointable->profile->uuid : null,
                        'likes_count' => $appointable->profile->likes_count,
                        'dislikes_count' => $appointable->profile->dislikes_count,
                    ])
                ) : null,
        ];
    }
}
