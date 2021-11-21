<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreRequest;
use App\Http\Resources\UserResource;
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
            data: [
                'success' => true,
                'status' => 201,
                'message' => 'Created',
                'data' => [
                    new UserResource(
                        resource: $user
                    ),
                ],
            ],
            status: 201
        );
    }
}
