<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyHasProfile;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Core\Resources\Api\V1\Shared\Traits\HasProfile;

trait HasAssemblies
{
    use HasType;
    use HasProfile;

    public function assemblies(JsonResource $resource): array
    {
        return [
            'assemblies_count' => $resource->assemblables_count ?? null,
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
                        'likes_count' => $assemblable->likes_count,
                        'dislikes_count' => $assemblable->dislikes_count,
                        'type'  => $this->type($assemblable),
                    ])
                ) : null,
        ];
    }

    public function assemblies_has_profile(JsonResource $resource): array
    {
        return [
            'assemblies_has_profile_count' => $resource->assemblables_has_profile_count ?? null,
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
                        'profile'  => $this->profile($assemblable),
                        'type'  => $this->type($assemblable),
                    ])
                ) : null,
        ];
    }
}
