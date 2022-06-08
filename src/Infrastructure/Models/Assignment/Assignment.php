<?php

declare(strict_types=1);

namespace Infrastructure\Models\Assignment;

use Infrastructure\Models\Assignment\AbstractAssignment;
use Infrastructure\Models\Comment\Comment;
use Infrastructure\Models\Like\Like;
use Infrastructure\Models\Post\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Assignment extends AbstractAssignment
{
    /** @var string */
    protected $morphClass = 'assignment';

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