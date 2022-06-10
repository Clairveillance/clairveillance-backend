<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use Domain\Core\V1\Repositories\UserRepositoryInterface;
use Infrastructure\Eloquent\Builders\Read\Users\GetAllUsers;

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
    ) {
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
