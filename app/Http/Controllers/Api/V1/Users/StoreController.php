<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreRequest;
use App\Jobs\Users\CreateUser as CreateUserJob;
use Domain\User\Factories\UserFactory;
use Illuminate\Http\JsonResponse;

final class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        // TODO: Auth.

        // NOTE: We use job to be able processing the action in the background.
        // We return nothing but status 202 with its corresponding message.
        CreateUserJob::dispatch(
            UserFactory::create(
                attributes: $request->validated(),
            )
        );

        return response()->json(
            data: [
                'success' => true,
                'status' => 202,
                'message' => 'Accepted',
                'data' => null,
            ],
            status: 202
        );

        /*
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
        */
    }
}
