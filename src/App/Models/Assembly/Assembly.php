<?php

declare(strict_types=1);

namespace App\Models\Assembly;

use App\Models\Assembly\AbstractAssembly;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Post\Post;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class Assembly extends AbstractAssembly
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

    public function assemblyAssemblables(): MorphToMany
    {
        return $this->morphToMany(
            related: $this::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyAssemblablesWithProfile(): MorphToMany
    {
        return $this->morphToMany(
            related: AssemblyWithProfile::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function userAssemblables(): MorphToMany
    {
        return $this->morphToMany(
            related: User::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assemblable_uuid',
            relatedPivotKey: 'assembly_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function assemblyAssemblies(): MorphToMany
    {
        return $this->morphedByMany(
            related: $this::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }

    public function assemblyAssembliesWithProfile(): MorphToMany
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

    public function assemblyEstablishments(): MorphToMany
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

    public function assemblyEstablishmentsWithProfile(): MorphToMany
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
}
