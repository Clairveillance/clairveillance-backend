<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Core\Controllers\Controller;
use App\Core\Resources\Api\V1\Users\UserResource;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShowController extends Controller
{
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.
        $user = new UserResource(
            resource: User::with(
                relations: ['profile', 'posts']
            )->where('uuid', $uuid)
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
