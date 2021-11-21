<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use Illuminate\Http\Request;
use Domain\Shared\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShowController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        return response()->json(
            data: new UserResource(
                resource: $user,
            ),
            status: 200,
        );
    }
}
