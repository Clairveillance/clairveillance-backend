<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use Domain\Shared\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    public function __invoke(Request $request): UserCollection|JsonResponse
    {
        return new UserCollection(
            resource: User::orderByUsername()->paginate(20)
        );
    }
}
