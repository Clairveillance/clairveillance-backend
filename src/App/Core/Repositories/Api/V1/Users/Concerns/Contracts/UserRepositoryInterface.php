<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users\Concerns\Contracts;

use App\Core\Resources\Api\V1\Users\UserCollection;

interface UserRepositoryInterface
{
    public function getAllUsers(
        string $orderBy,
        string $orderDirection,
        int $perPage
    ): UserCollection;
}
