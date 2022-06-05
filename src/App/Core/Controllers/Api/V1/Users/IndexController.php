<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Requests\Api\V1\Users\IndexRequest;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Core\Resources\Api\V1\Users\UserCollection;
use App\Core\Repositories\Api\Contracts\UserRepositoryInterface;
use App\Core\Controllers\Api\V1\Users\Traits\HasRelationships;

final class IndexController extends Controller
{
    use HasRelationships;

    // TODO: Add Authentication.
    public function __invoke(
        IndexRequest $request,
        UserRepositoryInterface $userRepository
    ): UserCollection {
        return $userRepository->getAllUsers(
            perPage: $request->validated()['per_page'],
            orderBy: $request->validated()['order_by'],
            orderDirection: $request->validated()['order_direction'],
            morphOneRelationships: $this->getMorphOneRelationships($request),
            hasManyRelationships: $this->getHasManyRelationships($request),
            morphToManyRelationships: $this->getMorphToManyRelationships($request),
            morphToManyRelationshipsHasProfile: $this->getMorphToManyRelationshipsHasProfile($request)
        );
    }
}
