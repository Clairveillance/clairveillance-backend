<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use Illuminate\Http\JsonResponse;
use Domain\User\Actions\CreateUser;
use App\Http\Controllers\Controller;
use Domain\User\Factories\UserFactory;
use App\Http\Requests\Api\V1\Users\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $user = CreateUser::handle(
            object: UserFactory::create(
                attributes: $request->validated(),
            )
        );

        return response()->json(
            data: $user,
            status: 201
        );
    }
}
