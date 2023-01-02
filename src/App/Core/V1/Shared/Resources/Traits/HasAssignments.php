<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use Infrastructure\Eloquent\Models\Assignment\Assignment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasType;
use App\Core\V1\Shared\Resources\Traits\HasLinks;
use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;

trait HasAssignments
{
    use HasType;
    use HasLinks;
    use HasProfile;
    use FormatDates;

    public function assignments(JsonResource $resource, string $name): array
    {
        return (array) [
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
                        'published_at' => $this->dateTimeToString($assignable->published_at),
                        // 'likes_total' => $assignable->likes_total,
                        'likes_count' => $assignable->likes_count,
                        'dislikes_count' => $assignable->dislikes_count,
                        'type'  => $this->type($assignable, 'assignments'),
                    ])
                ) : null,
        ];
    }

    public function assignments_has_profile(JsonResource $resource, string $name): array
    {
        return (array) [
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
                        'published_at' => $this->dateTimeToString($assignable->published_at),
                        'profile'  => $this->profile($assignable, 'assignments'),
                        'type'  => $this->type($assignable, 'assignments'),
                    ])
                ) : null,
        ];
    }
}
