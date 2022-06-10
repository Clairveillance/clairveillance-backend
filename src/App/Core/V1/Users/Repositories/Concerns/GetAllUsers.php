<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Repositories\Concerns;

use Infrastructure\Eloquent\Models\User\User;
use App\Core\V1\Users\Resources\UserCollection;
use Infrastructure\Eloquent\Builders\Relationships\HasMany;
use App\Core\V1\Shared\Repositories\Traits\HasRelationships;
use Infrastructure\Eloquent\Builders\Relationships\MorphOne;
use Infrastructure\Eloquent\Builders\Relationships\MorphToMany;

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
        call_user_func_array(
            callback: new MorphOne,
            args: [$query, $morphOneRelationships]
        );
        call_user_func_array(
            callback: new HasMany,
            args: [$query, $hasManyRelationships]
        );
        call_user_func_array(
            callback: new MorphToMany,
            args: [$query, $morphToManyRelationships]
        );
        call_user_func_array(
            callback: new MorphToMany,
            args: [$query, $morphToManyRelationshipsHasProfile, true]
        );
        HasRelationships::hasManyCount($query, $hasManyRelationships);
        HasRelationships::morphToManyCount($query, $morphToManyRelationships);
        HasRelationships::morphToManyHasProfileCount($query, $morphToManyRelationshipsHasProfile);
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
