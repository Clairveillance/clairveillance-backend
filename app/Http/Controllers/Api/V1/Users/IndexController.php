<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            return response()->json(new UserCollection(User::all()), 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'message' => $e->getMessage()
            ], 422, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
