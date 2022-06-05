<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentHasProfile;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasAssignments
{
    public function assignments(JsonResource $resource): array
    {
        return [
            'assignments_count' =>
            $resource->relationLoaded('assignables') ?
                $resource->assignables_count : null,
            'assignments' =>
            $resource->relationLoaded('assignables') ?
                $resource->assignables
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (Assignment $assignable) =>
                    collect([
                        'uuid' => $assignable->uuid,
                        'name' => $assignable->name,
                        'description' => $assignable->description,
                        'published_at' => $this->getFormattedDate($assignable->published_at),
                        'type_uuid' => $assignable->relationLoaded('type') ?
                            $assignable->type->uuid : null,
                        'type_name' => $assignable->relationLoaded('type') ?
                            $assignable->type->name : null,
                        'likes_count' => $assignable->likes_count,
                        'dislikes_count' => $assignable->dislikes_count,
                    ])
                ) : null,
        ];
    }

    public function assignments_has_profile(JsonResource $resource): array
    {
        return [
            'assignments_has_profile_count' =>
            $resource->relationLoaded('assignables_has_profile') ?
                $resource->assignables_has_profile_count : null,
            'assignments_has_profile' =>
            $resource->relationLoaded('assignables_has_profile') ?
                $resource->assignables_has_profile
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (AssignmentHasProfile $assignable) =>
                    collect([
                        'uuid' => $assignable->uuid,
                        'name' => $assignable->name,
                        'slug' => $assignable->slug,
                        'description' => $assignable->description,
                        'published_at' => $this->getFormattedDate($assignable->published_at),
                        'type_uuid' => $assignable->relationLoaded('type') ?
                            $assignable->type->uuid : null,
                        'type_name' => $assignable->relationLoaded('type') ?
                            $assignable->type->name : null,
                        'profile_uuid' => $assignable->relationLoaded('profile') ?
                            $assignable->profile->uuid : null,
                        'likes_count' => $assignable->profile->likes_count,
                        'dislikes_count' => $assignable->profile->dislikes_count,
                    ])
                ) : null,
        ];
    }
}
