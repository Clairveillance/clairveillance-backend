<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasType;
use App\Core\V1\Shared\Resources\Traits\HasLinks;

trait HasProfile
{
    use HasType;
    use HasLinks;
    use FormatDates;

    public function profile(JsonResource|Model $resource, string $name): array|null
    {
        return
            $resource->relationLoaded('profile') ?
            [
                'uuid' => $resource->profile->uuid ?? null,
                'published_at' => isset($resource->profile->published_at) ?
                    $this::dateTimeToString($resource->profile->published_at) : null,
                'likes_count' => $resource->profile->likes_count ?? null,
                'dislikes_count' => $resource->profile->dislikes_count ?? null,
                'type'  => isset(
                    $resource->profile
                ) ? $this->type($resource->profile, 'profile') : null,
            ] : null;
    }
}
