<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;

final class UserBuilder extends Builder
{
    public function orderByUsername(string $column = 'username', string $direction = 'asc'): self
    {
        return $this->orderBy(
            column: $column,
            direction: $direction
        );
    }
}
