<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Repositories\Concerns;

use Infrastructure\Models\User\User;
use App\Core\V1\Users\Resources\UserCollection;
use App\Core\V1\Shared\Repositories\Traits\HasRelationships;

abstract class GetAllUsers
{
    use HasRelationships;

    public static function withRelations(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        array $morphOneRelationships,
        array $hasManyRelationships,
        array $morphToManyRelationships,
        array $morphToManyRelationshipsHasProfile,
    ): UserCollection {
        $query = User::select(
            'uuid',
            'username',
            'firstname',
            'lastname',
            'description',
            'email',
            'created_at',
            'updated_at'
        );
        HasRelationships::morphOne($query, $morphOneRelationships);
        HasRelationships::hasManyCount($query, $hasManyRelationships);
        HasRelationships::hasMany($query, $hasManyRelationships);
        HasRelationships::morphToManyCount($query, $morphToManyRelationships);
        HasRelationships::morphToMany($query, $morphToManyRelationships);
        HasRelationships::morphToManyHasProfileCount($query, $morphToManyRelationshipsHasProfile);
        HasRelationships::morphToManyHasProfile($query, $morphToManyRelationshipsHasProfile);
        $query = $query->orderBy(
            column: $orderBy,
            direction: $orderDirection
        )
            // ->withTrashed() //NOTE
            // ->onlyTrashed() //NOTE
            ->paginate(
                perPage: $perPage,
                columns: ['id'],
                pageName: 'page',
                page: null
            );
        $users = new UserCollection($query);
        $users::$wrap = 'users';
        return $users;
    }
}