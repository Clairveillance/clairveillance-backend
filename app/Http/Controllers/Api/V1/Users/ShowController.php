<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id)
    {
        return response()->json(new UserResource(User::findOrFail($id)), 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
