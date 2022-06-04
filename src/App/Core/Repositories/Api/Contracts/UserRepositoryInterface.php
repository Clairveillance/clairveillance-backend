<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\Contracts;

use App\Core\Resources\Api\V1\Users\UserCollection;

interface UserRepositoryInterface
{
    public function getAllUsers(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        array $morphOneRelationships,
        array $hasManyRelationships,
        array $morphToManyRelationships,
        array $morphToManyRelationshipsHasProfile,
    ): UserCollection;
}
