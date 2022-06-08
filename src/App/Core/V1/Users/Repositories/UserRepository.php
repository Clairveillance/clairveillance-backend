<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Repositories;

use App\Core\V1\Users\Resources\UserCollection;
use App\Core\V1\Users\Repositories\Concerns\GetAllUsers;
use Domain\Core\V1\Users\Repositories\UserRepositoryInterface;

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
