<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyHasProfile;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasAssemblies
{
    public function assemblies(JsonResource $resource): array
    {
        return [
            'assemblies_count' =>
            $resource->relationLoaded('assemblables') ?
                $resource->assemblables_count : null,
            'assemblies' =>
            $resource->relationLoaded('assemblables') ?
                $resource->assemblables
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (Assembly $assemblable) =>
                    collect([
                        'uuid' => $assemblable->uuid,
                        'name' => $assemblable->name,
                        'description' => $assemblable->description,
                        'published_at' => $this->getFormattedDate($assemblable->published_at),
                        'type_uuid' => $assemblable->relationLoaded('type') ?
                            $assemblable->type->uuid : null,
                        'type_name' => $assemblable->relationLoaded('type') ?
                            $assemblable->type->name : null,
                        'likes_count' => $assemblable->likes_count,
                        'dislikes_count' => $assemblable->dislikes_count,
                    ])
                ) : null,
        ];
    }

    public function assemblies_has_profile(JsonResource $resource): array
    {
        return [
            'assemblies_has_profile_count' =>
            $resource->relationLoaded('assemblables_has_profile') ?
                $resource->assemblables_has_profile_count : null,
            'assemblies_has_profile' =>
            $resource->relationLoaded('assemblables_has_profile') ?
                $resource->assemblables_has_profile
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (AssemblyHasProfile $assemblable) =>
                    collect([
                        'uuid' => $assemblable->uuid,
                        'name' => $assemblable->name,
                        'slug' => $assemblable->slug,
                        'description' => $assemblable->description,
                        'published_at' => $this->getFormattedDate($assemblable->published_at),
                        'type_uuid' => $assemblable->relationLoaded('type') ?
                            $assemblable->type->uuid : null,
                        'type_name' => $assemblable->relationLoaded('type') ?
                            $assemblable->type->name : null,
                        'profile_uuid' => $assemblable->relationLoaded('profile') ?
                            $assemblable->profile->uuid : null,
                        'likes_count' => $assemblable->profile->likes_count,
                        'dislikes_count' => $assemblable->profile->dislikes_count,
                    ])
                ) : null,
        ];
    }
}
