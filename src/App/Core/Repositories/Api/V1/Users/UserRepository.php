<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users;

use App\Core\Resources\Api\V1\Users\UserCollection;
use App\Core\Repositories\Api\V1\Users\Concerns\GetAllUsers;
use App\Core\Repositories\Api\V1\Users\Concerns\Contracts\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(
        string $orderBy,
        string $orderDirection,
        int $perPage
    ): UserCollection {
        return GetAllUsers::withRelationsPaginated(
            (string) $orderBy,
            (string) $orderDirection,
            (int) $perPage
        );
    }
}
