<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Posts;

use App\Core\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexByUserController extends Controller
{
    public function __invoke(Request $request, string $uuid): LengthAwarePaginator
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.
        $posts = Post::where('user_uuid', $uuid)->orderByDesc('published_at')->paginate(25);
        // $posts::$wrap = 'data';
        return $posts;
    }
}