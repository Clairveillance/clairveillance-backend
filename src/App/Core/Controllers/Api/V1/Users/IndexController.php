<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Core\Resources\UserCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class IndexController extends Controller
{
    //TODO: Auth.

    public function __invoke(Request $request): UserCollection
    {
        // NOTE: Used to debug the time of execution of a script.
        // $time_start = microtime(true);
        $users = new UserCollection(
            resource: User::with(
                relations: [
                    'posts' => function (HasMany $posts) {
                        $posts->published_posts();
                    },
                    'profile',
                    'assemblables' => function (MorphToMany $assemblables) {
                        $assemblables->withCount(['likes']);
                    },
                    'assemblables_has_profile',
                ]
            )
                ->withCount(
                    relations: [
                        'posts' => function (PostQueryBuilder $posts) {
                            $posts->published_posts();
                        },
                        'assemblables',
                        'assemblables_has_profile',
                    ]
                )
                // ->withTrashed()
                // ->onlyTrashed()
                ->orderBy('username')
                ->paginate(25)
        );
        $users::$wrap = 'data';
        /*
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        dump(round((($time) * 1000), 2) . "ms");
        */
        return $users;
    }
}
