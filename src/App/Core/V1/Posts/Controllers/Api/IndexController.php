<?php

declare(strict_types=1);

namespace App\Core\V1\Posts\Controllers\Api;

use App\Core\V1\Controller;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexController extends Controller
{
    public function __invoke(Request $request): LengthAwarePaginator
    {
        // TODO: Add Authentication.
        // TODO: Add FormRequest for validations.
        $posts = Post::published()->orderByDesc('published_at')->paginate(25);
        // $posts::$wrap = 'data';
        return $posts;
    }
}
