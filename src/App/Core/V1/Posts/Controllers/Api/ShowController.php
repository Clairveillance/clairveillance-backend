<?php

declare(strict_types=1);

namespace App\Core\V1\Posts\Controllers\Api;

use App\Core\V1\Controller;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShowController extends Controller
{
    public function __invoke(Request $request, string $slug): JsonResponse
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.
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
