<?php

declare(strict_types=1);

namespace App\Models\Shared;

use Illuminate\Database\Eloquent\Builder;

final class CustomQueryBuilder extends Builder
{
    public function orderByUsername(string $column = 'username', string $direction = 'asc'): self
    {
        return $this->orderBy(
            column: $column,
            direction: $direction
        );
    }
}
