<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\Like\Like;
use App\Models\Post\Post;
use App\Models\User\User;
use App\Models\Comment\Comment;
use App\Models\Assignment\AbstractAssignment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class Assignment extends AbstractAssignment
{
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

    public function assignmentAssignables(): MorphToMany
    {
        return $this->morphToMany(
            related: $this::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userAssignables(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignable_uuid',
            relatedPivotKey: 'assignment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentAssignments(): MorphToMany
    {
        return $this->morphedByMany(
            related: $this::class,
            name: 'assignable',
            table: null,
            foreignPivotKey: 'assignment_uuid',
            relatedPivotKey: 'assignable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
