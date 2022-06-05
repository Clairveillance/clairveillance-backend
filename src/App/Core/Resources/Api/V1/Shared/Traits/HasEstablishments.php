<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Establishment\Establishment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Models\Establishment\EstablishmentHasProfile;

trait HasEstablishments
{
    use HasType;
    use HasProfile;

    public function establishments(JsonResource $resource): array
    {
        return [
            'establishments_count' => $resource->establishables_count ?? null,
            'establishments' =>
            $resource->relationLoaded('establishables') ?
                $resource->establishables
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (Establishment $establishable) =>
                    collect([
                        'uuid' => $establishable->uuid,
                        'name' => $establishable->name,
                        'description' => $establishable->description,
                        'published_at' => $this->getFormattedDate($establishable->published_at),
                        'likes_count' => $establishable->likes_count,
                        'dislikes_count' => $establishable->dislikes_count,
                        'type'  => $this->type($establishable),
                    ])
                ) : null,
        ];
    }

    public function establishments_has_profile(JsonResource $resource): array
    {
        return [
            'establishments_has_profile_count' => $resource->establishables_has_profile_count ?? null,
            'establishments_has_profile' =>
            $resource->relationLoaded('establishables_has_profile') ?
                $resource->establishables_has_profile
                ->sortBy(
                    callback: (array) ['type.name', 'name'],
                    options: (int) SORT_REGULAR,
                    descending: (bool) false
                )
                ->map(
                    fn (EstablishmentHasProfile $establishable) =>
                    collect([
                        'uuid' => $establishable->uuid,
                        'name' => $establishable->name,
                        'slug' => $establishable->slug,
                        'description' => $establishable->description,
                        'published_at' => $this->getFormattedDate($establishable->published_at),
                        'profile'  => $this->profile($establishable),
                        'type'  => $this->type($establishable),
                    ])
                ) : null,
        ];
    }
}
