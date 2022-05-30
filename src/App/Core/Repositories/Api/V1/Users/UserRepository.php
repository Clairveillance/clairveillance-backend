<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users;

use App\Core\Repositories\Api\V1\Users\Concerns\Abstractions\GetAllUsers;
use App\Core\Repositories\Api\V1\Users\Concerns\Contracts\UserRepositoryInterface;
use App\Core\Resources\Api\V1\Users\UserCollection;

final class UserRepository extends GetAllUsers implements UserRepositoryInterface
{
    /**
     * getAllUsers
     *
     * @return \App\Core\Resources\Api\V1\Users\UserCollection
     */
    public function getAllUsers(string $orderBy = 'username', string $orderDirection = 'asc', int $perPage = 25): UserCollection
    {
        return GetAllUsers::withRelationsPaginated($orderBy, $orderDirection, $perPage);
    }
}
