<?php

declare(strict_types=1);

namespace App\Models\Assembly;

use App\Models\Like\Like;
use App\Models\User\User;
use App\Models\Comment\Comment;
use App\Models\Assembly\AbstractAssembly;
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
}
