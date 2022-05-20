<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Requests\Api\V1\Users\UpdateRequest;
use App\Factories\UserFactory;
use App\Jobs\UpdateUserJob;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;

final class UpdateController extends Controller
{
    //TODO: Auth.

    public function __invoke(UpdateRequest $request, User $user): JsonResponse
    {
        //TODO: Auth.

        // NOTE: We use job to be able processing the action in the background.
        // We return nothing but status 202 with its corresponding message.
        UpdateUserJob::dispatch(
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
        UpdateUserAction::handle(
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
