<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Read\Users;

use Infrastructure\Eloquent\Models\User\User;
use Infrastructure\Eloquent\Builders\Read\Relationships\HasMany;
use Infrastructure\Eloquent\Builders\Read\Relationships\MorphOne;
use Infrastructure\Eloquent\Builders\Read\Relationships\MorphToMany;
use Infrastructure\Eloquent\Builders\Read\Relationships\HasManyCount;
use Infrastructure\Eloquent\Builders\Read\Relationships\MorphToManyCount;

abstract class GetAllUsers
{
    public static function withRelations(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        array $morphOneRelationships,
        array $hasManyRelationships,
        array $morphToManyRelationships,
        array $morphToManyRelationshipsHasProfile,
    ) {
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
            callback: new HasManyCount,
            args: [$query, $hasManyRelationships]
        );
        call_user_func_array(
            callback: new MorphToMany,
            args: [$query, $morphToManyRelationships]
        );
        call_user_func_array(
            callback: new MorphToManyCount,
            args: [$query, $morphToManyRelationships]
        );
        call_user_func_array(
            callback: new MorphToMany,
            args: [$query, $morphToManyRelationshipsHasProfile, true]
        );
        call_user_func_array(
            callback: new MorphToManyCount,
            args: [$query, $morphToManyRelationshipsHasProfile]
        );
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
        return $query;
    }
}
