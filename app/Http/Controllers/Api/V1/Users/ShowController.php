<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShowController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request, User $user): JsonResponse
    {
        $user = new UserResource(
            resource: $user
        );

        return response()->json(
            data: [
                'succes' => true,
                'status' => 200,
                'message' => 'OK',
                'data' => $user,
            ],
            status: 200
        );
    }
}
