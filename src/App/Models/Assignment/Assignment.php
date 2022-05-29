<?php

declare(strict_types=1);

namespace App\Models\Assignment;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\AbstractAssignment;
use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Post\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function assignmentEstablishments(): MorphToMany
    {
        return $this->morphedByMany(
            related: Establishment::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentEstablishmentsWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: EstablishmentWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishment_uuid',
            relatedPivotKey: 'establishable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentAssemblies(): MorphToMany
    {
        return $this->morphedByMany(
            related: Assembly::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assignmentAssembliesHasProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: AssemblyHasProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
