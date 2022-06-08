<?php

declare(strict_types=1);

namespace Interface\Controllers\Api\V1\Users;

use Interface\Controllers\Controller;
use App\Core\Factories\UserFactory;
use App\Core\Jobs\UpdateUserJob;
use App\Core\Requests\Api\V1\Users\UpdateRequest;
use Infrastructure\Models\User\User;
use Illuminate\Http\JsonResponse;

final class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user): JsonResponse
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.

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
