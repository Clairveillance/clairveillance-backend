<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse
    {
        try {
            return response()->json(new UserResource(User::findOrFail($id)), 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'succes' => false,
                'message' => 'No user found with id ' . $id
            ], 404, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'message' => $e->getMessage()
            ], 422, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
