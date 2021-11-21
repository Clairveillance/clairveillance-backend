<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\UpdateRequest;
use App\Http\Resources\UserResource;
use Domain\User\Actions\UpdateUser;
use Domain\User\Factories\UserFactory;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;

final class UpdateController extends Controller
{
    //TODO: Auth.

    public function __invoke(UpdateRequest $request, User $user): JsonResponse
    {
        //TODO: Auth.
        //TODO: Move this to job.

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
    }
}
