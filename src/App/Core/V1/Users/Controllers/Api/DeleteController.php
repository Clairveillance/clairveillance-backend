<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\V1\Controller;
use App\Core\V1\Users\Jobs\DeleteUserJob;
use Infrastructure\Eloquent\Models\User\User;

final class DeleteController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.

        // NOTE: We use job to be able processing the action in the background.
        // We return nothing but status 202 with its corresponding message.
        DeleteUserJob::dispatch(
            $user->id,
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
    }
}
