<?php

declare(strict_types=1);

namespace Interface\Controllers\Api\V1\Users;

use Interface\Controllers\Controller;
use App\Core\V1\Users\Requests\IndexRequest;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Core\V1\Users\Resources\UserCollection;
use Interface\Controllers\Api\V1\Shared\Traits\HasRelationships;
use Domain\Core\V1\Users\Boundaries\Inputs\Repositories\UserRepositoryInterface;

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
