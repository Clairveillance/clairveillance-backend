<?php

declare(strict_types=1);

namespace Interface\Controllers\Api\V1\Users;

use Interface\Controllers\Controller;
use App\Core\V1\Users\Factories\UserFactory;
use App\Core\V1\Users\Jobs\CreateUserJob;
use App\Core\V1\Users\Requests\StoreRequest;
use Illuminate\Http\JsonResponse;

final class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.

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
        $user = CreateUserAction::handle(
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
