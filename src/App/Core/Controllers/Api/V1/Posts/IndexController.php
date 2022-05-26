<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Posts;

use App\Core\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request): LengthAwarePaginator
    {
        // NOTE: Used to debug the time of execution of a script.
        // $time_start = microtime(true);
        $posts = Post::orderByDesc('published_at')->paginate(25);
        // $posts::$wrap = 'data';
        /*
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        dump(round((($time) * 1000), 2) . "ms");
        */
        return $posts;
    }
}
