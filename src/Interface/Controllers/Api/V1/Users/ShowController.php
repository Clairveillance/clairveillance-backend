<?php

declare(strict_types=1);

namespace Interface\Controllers\Api\V1\Users;

use Interface\Controllers\Controller;
use App\Core\V1\Users\Resources\UserResource;
use Infrastructure\Models\User\User;
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