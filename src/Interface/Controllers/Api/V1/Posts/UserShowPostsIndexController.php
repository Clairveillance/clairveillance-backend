<?php

declare(strict_types=1);

namespace Interface\Controllers\Api\V1\Posts;

use Interface\Controllers\Controller;
use Infrastructure\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class UserShowPostsIndexController extends Controller
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
