<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Core\Resources\Api\V1\Shared\Traits\HasLinks;

trait HasProfile
{
    use HasType;
    use HasLinks;

    public function profile(JsonResource|Model $resource, string $name): array|null
    {
        return
            $resource->relationLoaded('profile') ?
            [
                'uuid' => $resource->profile->uuid ?? null,
                'published_at' => isset($resource->profile->published_at) ?
                    $this->getFormattedDate($resource->profile->published_at) : null,
                'likes_count' => $resource->profile->likes_count ?? null,
                'dislikes_count' => $resource->profile->dislikes_count ?? null,
                // 'type'  => $this->type($resource->profile), //NOTE
            ] : null;
    }
}
