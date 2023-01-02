<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasLinks;

trait HasType
{

    use HasLinks;

    public function type(JsonResource|Model $resource, string $name): array|null
    {
        return
            $resource->relationLoaded('type') ?
            (array) [
                'uuid' => $resource->type->uuid ?? null,
                'name' => $resource->type->name ?? null,
            ] : null;
    }
}
