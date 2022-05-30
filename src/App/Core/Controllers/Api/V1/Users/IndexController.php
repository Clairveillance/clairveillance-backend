<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Core\Resources\Api\V1\Users\UserCollection;
use App\Core\Repositories\Api\V1\Users\UserRepository;

final class IndexController extends Controller
{
    public function __construct(public UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request): UserCollection
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.
        return $this->userRepository->getAllUsers(
            orderBy: 'username',
            orderDirection: 'asc',
            perPage: 25
        );
    }
}
