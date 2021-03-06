<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Shared\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

final class CustomQueryBuilder extends Builder
{
    public function published(bool $value = true): self
    {
        return $this->where('published', $value) ?? null;
    }

    public function unpublished(bool $value = true): self
    {
        $value = $value !== true ?: false;

        return $this->where('published', $value) ?? null;
    }
}
