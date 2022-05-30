<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users;

use App\Core\Repositories\Api\V1\Users\Concerns\GetAllUsers;
use App\Core\Resources\UserCollection;

final class UserRepository extends GetAllUsers
{
    /**
     * getAllUsers
     *
     * @return \App\Core\Resources\UserCollection
     */
    public function getAllUsers(): UserCollection
    {
        return GetAllUsers::withRelationsPaginated();
    }
}
