<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Controllers\Api;

use App\Core\V1\Controller;
use App\Core\V1\Users\Requests\IndexRequest;
use App\Core\V1\Shared\Traits\HasRelationships;
use App\Core\V1\Users\Resources\UserCollection;
use Illuminate\Foundation\Auth\User as AuthUser;
use Domain\Core\V1\Repositories\UserRepositoryInterface;

final class IndexController extends Controller
{
    use HasRelationships;

    // TODO: Add Authentication.
    public function __invoke(
        IndexRequest $request,
        UserRepositoryInterface $userRepository
    ) {
        $query = $userRepository->getAllUsers(
            perPage: $request->validated()['per_page'],
            orderBy: $request->validated()['order_by'],
            orderDirection: $request->validated()['order_direction'],
            morphOneRelationships: $this->getMorphOneRelationships($request),
            hasManyRelationships: $this->getHasManyRelationships($request),
            morphToManyRelationships: $this->getMorphToManyRelationships($request),
            morphToManyRelationshipsHasProfile: $this->getMorphToManyRelationshipsHasProfile($request)
        );
        $users = new UserCollection($query);
        $users::$wrap = 'users';
        return $users;
    }
}
