<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Support\FormatDate;
use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentHasProfile;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Core\Resources\Api\V1\Shared\Traits\HasLinks;

trait HasAssignments
{
    use HasType;
    use HasLinks;
    use HasProfile;

    public function assignments(JsonResource $resource, string $name): array
    {
        return [
            'assignments_count' => $resource->assignables_count ?? null,
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
                        'published_at' => FormatDate::humanizeYmdHis($assignable->published_at),
                        'likes_count' => $assignable->likes_count,
                        'dislikes_count' => $assignable->dislikes_count,
                        'type'  => $this->type($assignable, 'assignments'),
                    ])
                ) : null,
        ];
    }

    public function assignments_has_profile(JsonResource $resource, string $name): array
    {
        return [
            'assignments_has_profile_count' => $resource->assignables_has_profile_count ?? null,
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
                        'published_at' => FormatDate::humanizeYmdHis($assignable->published_at),
                        'profile'  => $this->profile($assignable, 'assignments'),
                        'type'  => $this->type($assignable, 'assignments'),
                    ])
                ) : null,
        ];
    }
}
