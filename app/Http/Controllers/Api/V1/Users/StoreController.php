<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreRequest;
use Domain\User\Actions\CreateUser;
use Domain\User\Factories\UserFactory;
use Illuminate\Http\JsonResponse;

final class StoreController extends Controller
{
    //TODO: Auth.

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
