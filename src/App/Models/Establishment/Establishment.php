<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Comment\Comment;
use App\Models\Establishment\AbstractEstablishment;
use App\Models\Like\Like;
use App\Models\Post\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function assemblyEstablishables(): MorphToMany
    {
        return $this->morphToMany(
            related: Assembly::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyWithProfileEstablishables(): MorphToMany
    {
        return $this->morphToMany(
            related: AssemblyWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentEstablishables(): MorphToMany
    {
        return $this->morphToMany(
            related: Assignment::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assignmentWithProfileEstablishables(): MorphToMany
    {
        return $this->morphToMany(
            related: AssignmentWithProfile::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userEstablishables(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'establishable',
            table: null,
            foreignPivotKey: 'establishable_uuid',
            relatedPivotKey: 'establishment_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function establishmentAssemblies(): MorphToMany
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

    public function establishmentAssembliesWithProfile(): MorphToMany
    {
        return $this->morphedByMany(
            related: AssemblyWithProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
