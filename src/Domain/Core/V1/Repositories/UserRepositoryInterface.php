<?php

declare(strict_types=1);

namespace Domain\Core\V1\Repositories;

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
    );
}
