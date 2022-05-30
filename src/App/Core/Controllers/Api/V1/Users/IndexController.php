<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Core\Resources\UserCollection;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Core\Repositories\Api\V1\Users\UserRepository;

final class IndexController extends Controller
{
    // TODO: Add Authentication.
    // TODO: Add FormRequest for validations.

    public function __construct(public UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request): UserCollection
    {
        return $this->userRepository->getAllUsers();
    }
}
