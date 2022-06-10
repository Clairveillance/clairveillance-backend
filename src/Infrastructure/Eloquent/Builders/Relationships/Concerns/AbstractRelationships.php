<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Relationships\Concerns;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractRelationships
{
    protected static function likesCount(): array
    {
        return
            [
                // 'likes as likes_total', //NOTE
                'likes as likes_count' => fn (Builder $likes) => $likes->where('is_dislike', 0),
                'likes as dislikes_count' => fn (Builder $likes) => $likes->where('is_dislike', 1),
            ];
    }
}
