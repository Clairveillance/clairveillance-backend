<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShowController extends Controller
{
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        try {
            return response()->json(
                data: new UserResource(
                    resource: User::where('uuid', $uuid)->firstOrfail(),
                ),
                status: 200,
            );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'succes' => false,
                'status' => 404,
                'message' => 'No user found with uuid '.$uuid,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
