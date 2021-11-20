<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    public function __invoke(Request $request): UserCollection|JsonResponse
    {
        $users = new UserCollection(User::paginate(20));
        try {
            return $users;
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
