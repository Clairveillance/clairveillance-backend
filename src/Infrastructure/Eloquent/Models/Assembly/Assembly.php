<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Assembly;

use Infrastructure\Eloquent\Models\Assembly\AbstractAssembly;
use Infrastructure\Eloquent\Models\Comment\Comment;
use Infrastructure\Eloquent\Models\Like\Like;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Assembly extends AbstractAssembly
{
    /** @var string */
    protected $morphClass = 'assembly';

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
