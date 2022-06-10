<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Establishment;

use Infrastructure\Eloquent\Models\Comment\Comment;
use Infrastructure\Eloquent\Models\Establishment\AbstractEstablishment;
use Infrastructure\Eloquent\Models\Like\Like;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Establishment extends AbstractEstablishment
{
    /** @var string */
    protected $morphClass = 'establishment';

    public function comments(): MorphMany
    {
        return $this->morphMany(
            related: Comment::class,
            name: 'commentable',
            type: 'commentable_type',
            id: 'commentable_uuid',
            localKey: 'uuid'
        );
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(
            related: Like::class,
            name: 'likeable',
            type: 'likeable_type',
            id: 'likeable_uuid',
            localKey: 'uuid'
        );
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(
            related: Post::class,
            name: 'postable',
            type: 'postable_type',
            id: 'postable_uuid',
            localKey: 'uuid'
        );
    }
}
