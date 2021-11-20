<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

final class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): UserResource|JsonResponse
    {
        try {
            return new UserResource(User::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'succes' => false,
                'status' => 404,
                'message' => 'No user found with id ' . $id
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'status' => 422,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
