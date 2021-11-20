<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $users = new UserCollection(User::paginate(20));
        try {
            return $users;
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'status' => 422,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
