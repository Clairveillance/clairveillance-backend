<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Posts;

use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Controllers\Controller;

final class ShowController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request, string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return response()->json(
            data: [
                'succes' => true,
                'status' => 200,
                'message' => 'OK',
                'data' => $post,
            ],
            status: 200
        );
    }
}
