<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use Infrastructure\Models\Assembly\Assembly;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasType;
use App\Core\V1\Shared\Resources\Traits\HasLinks;
use App\Core\V1\Shared\Resources\Traits\HasProfile;
use Infrastructure\Models\Assembly\AssemblyHasProfile;

trait HasAssemblies
{
    use HasType;
    use HasLinks;
    use HasProfile;
    use FormatDates;

    public function assemblies(JsonResource $resource, string $name): array
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
                        'published_at' => $this::dateTimeToString($assemblable->published_at),
                        'likes_count' => $assemblable->likes_count,
                        'dislikes_count' => $assemblable->dislikes_count,
                        'type'  => $this->type($assemblable, 'assemblies'),
                    ])
                ) : null,
        ];
    }

    public function assemblies_has_profile(JsonResource $resource, string $name): array
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
                        'published_at' => $this::dateTimeToString($assemblable->published_at),
                        'profile'  => $this->profile($assemblable, 'assemblies'),
                        'type'  => $this->type($assemblable, 'assemblies'),
                    ])
                ) : null,
        ];
    }
}
