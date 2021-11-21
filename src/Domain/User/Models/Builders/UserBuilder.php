<?php

declare(strict_types=1);

namespace Domain\User\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

final class UserBuilder extends Builder
{
    public function orderByUsername(): self
    {
        return $this->orderBy(
            column: 'username',
            direction: 'asc'
        );
    }

    public function deleted(): self
    {
        return $this->where(
            column: 'deleted_at',
            operator: '!=',
            value: null
        );
    }
}
