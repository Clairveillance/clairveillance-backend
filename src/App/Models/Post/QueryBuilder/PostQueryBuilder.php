<?php

declare(strict_types=1);

namespace App\Models\Post\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

final class PostQueryBuilder extends Builder
{
    public function published_posts(bool $value = true): self
    {
        return $this->where('published', $value);
    }
}
