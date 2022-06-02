<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Requests\Api\V1\Users\IndexRequest;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Core\Resources\Api\V1\Users\UserCollection;
use App\Core\Repositories\Api\Contracts\UserRepositoryInterface;

final class IndexController extends Controller
{
    // TODO: Add Authentication.
    public function __invoke(
        IndexRequest $request,
        UserRepositoryInterface $userRepository
    ): UserCollection {
        return $userRepository->getAllUsers(
            orderBy: $request->validated()['order_by'],
            orderDirection: $request->validated()['order_direction'],
            perPage: $request->validated()['per_page']
        );
    }
}
