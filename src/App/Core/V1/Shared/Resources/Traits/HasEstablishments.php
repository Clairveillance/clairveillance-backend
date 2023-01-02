<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasType;
use App\Core\V1\Shared\Resources\Traits\HasLinks;
use Infrastructure\Eloquent\Models\Establishment\Establishment;
use Infrastructure\Eloquent\Models\Establishment\EstablishmentHasProfile;

trait HasEstablishments
{
    use HasType;
    use HasLinks;
    use HasProfile;
    use FormatDates;

    /**
     * establishments
     *
     * @param  mixed $resource
     * @param  string $name
     * @return array
     */
    public function establishments(JsonResource $resource, string $name): array
    {
        return (array) [
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
                        'published_at' => $this->dateTimeToString($establishable->published_at),
                        // 'likes_total' => $establishable->likes_total,
                        'likes_count' => $establishable->likes_count,
                        'dislikes_count' => $establishable->dislikes_count,
                        'type'  => $this->type($establishable, 'establishments'),
                    ])
                ) : null,
        ];
    }

    /**
     * establishments_has_profile
     *
     * @param  mixed $resource
     * @param  string $name
     * @return array
     */
    public function establishments_has_profile(JsonResource $resource, string $name): array
    {
        return (array) [
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
                        'published_at' => $this->dateTimeToString($establishable->published_at),
                        'profile'  => $this->profile($establishable, 'establishments'),
                        'type'  => $this->type($establishable, 'establishments'),
                    ])
                ) : null,
        ];
    }
}
