<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Repositories\Api\Contracts\UserRepositoryInterface;
use App\Core\Requests\Api\V1\Users\IndexRequest;
use App\Core\Resources\Api\V1\Users\UserCollection;
use Illuminate\Foundation\Auth\User as AuthUser;

final class IndexController extends Controller
{
    // TODO: Add Authentication.
    public function __invoke(
        IndexRequest $request,
        UserRepositoryInterface $userRepository
    ): UserCollection {
        return $userRepository->getAllUsers(
            perPage: $request->validated()['per_page'],
            orderBy: $request->validated()['order_by'],
            orderDirection: $request->validated()['order_direction'],
            morphOneRelationships: [
                'profile' => (bool)$request->validated()['profile'],
            ],
            hasManyRelationships: [
                'posts' => (bool)$request->validated()['posts'],
            ],
            morphToManyRelationships: [
                'appointables' => (bool)$request->validated()['appointables'],
                'assemblables' => (bool)$request->validated()['assemblables'],
                'assignables' => (bool)$request->validated()['assignables'],
                'establishables' => (bool)$request->validated()['establishables'],
            ],
            morphToManyRelationshipsHasProfile: [
                'appointables_has_profile' => (bool)$request->validated()['appointables_has_profile'],
                'assemblables_has_profile' => (bool)$request->validated()['assemblables_has_profile'],
                'assignables_has_profile' => (bool)$request->validated()['assignables_has_profile'],
                'establishables_has_profile' => (bool)$request->validated()['establishables_has_profile'],
            ]
        );
    }
}
