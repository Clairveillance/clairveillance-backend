<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Jobs\Users\UpdateUser;
use Domain\User\Factories\UserFactory;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;

final class UpdateController extends Controller
{
    //TODO: Auth.

    public function __invoke(UpdateRequest $request, User $user): JsonResponse
    {
        //TODO: Auth.

        // NOTE: We use job to be able processing the action in the background.
        // We return nothing but status 202 with its corresponding message.
        UpdateUser::dispatch(
            $user->id,
            UserFactory::create(
                attributes: $request->validated(),
            ),
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
        UpdateUser::handle(
            object: UserFactory::create(
                attributes: $request->validated(),
            ),
            user: $user
        );

        return response()->json(
            data: [
                'success' => true,
                'status' => 202,
                'message' => 'Accepted',
                'data' => [
                    new UserResource(
                        resource: $user
                    ),
                ],
            ],
            status: 202
        );
        */
    }
}
