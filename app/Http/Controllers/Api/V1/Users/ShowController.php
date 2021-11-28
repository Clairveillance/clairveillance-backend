<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

final class ShowController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $user = new UserResource(
            resource: User::where('uuid', $uuid)
                // ->withTrashed()
                ->firstOrFail()
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
