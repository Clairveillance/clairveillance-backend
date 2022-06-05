<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasType
{
    public function type(JsonResource|Model $resource): array|null
    {
        return
            $resource->relationLoaded('type') ?
            [
                'uuid' => $resource->type->uuid ?? null,
                'name' => $resource->type->name ?? null,
            ] : null;
    }
}
