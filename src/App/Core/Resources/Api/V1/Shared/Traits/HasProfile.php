<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait HasProfile
{
    public function profile(JsonResource $resource): array|null
    {
        return
            $resource->relationLoaded('profile') ?
            [
                'uuid' => $resource->profile->uuid ?? null,
                'published_at' => isset($resource->profile->published_at) ?
                    $this->getFormattedDate($resource->profile->published_at) : null,
                'likes_count' => $resource->profile->likes_count ?? null,
                'dislikes_count' => $resource->profile->dislikes_count ?? null,
            ] : null;
    }
}
