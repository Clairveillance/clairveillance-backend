<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\Assignment\AbstractAssignment;
use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Post\Post;
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
