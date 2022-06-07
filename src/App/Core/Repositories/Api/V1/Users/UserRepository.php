<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users;

use App\Core\Resources\Api\V1\Users\UserCollection;
use App\Core\Repositories\Api\V1\Users\Concerns\GetAllUsers;
use App\Core\Repositories\Api\Contracts\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        array $morphOneRelationships,
        array $hasManyRelationships,
        array $morphToManyRelationships,
        array $morphToManyRelationshipsHasProfile,
    ): UserCollection {
        return GetAllUsers::withRelations(
            (int) $perPage,
            (string) $orderBy,
            (string) $orderDirection,
            (array) $morphOneRelationships,
            (array) $hasManyRelationships,
            (array) $morphToManyRelationships,
            (array) $morphToManyRelationshipsHasProfile,
        );
    }
}
