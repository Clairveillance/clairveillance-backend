<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasLinks;

trait HasType
{

    use HasLinks;

    public function type(JsonResource|Model $resource, string $name): array|null
    {
        return
            $resource->relationLoaded('type') ?
            [
                'uuid' => $resource->type->uuid ?? null,
                'name' => $resource->type->name ?? null,
            ] : null;
    }
}
