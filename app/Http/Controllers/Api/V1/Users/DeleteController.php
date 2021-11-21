<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DeleteController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        //TODO: Auth.
        //TODO: Move this to job.

        $user->delete();

        return response()->json(
            data: [
                'success' => true,
                'status' => 202,
                'message' => 'Accepted',
                'data' => null
            ],
            status: 202
        );
    }
}
