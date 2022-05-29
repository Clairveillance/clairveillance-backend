<?php

declare(strict_types=1);

namespace App\Core\Controllers\Api\V1\Users;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use App\Core\Resources\UserCollection;
use App\Models\Assembly\AssemblyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use GraphQL\Type\Definition\Type;
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
            resource: User::select(
                'uuid',
                'username',
                'firstname',
                'lastname',
                'description',
                'email',
                'created_at',
                'updated_at'
            )
                ->with(
                    relations: [
                        'assemblables' => function (MorphToMany $assemblables) {
                            $assemblables->withCount(
                                [
                                    // 'likes as likes_total',
                                    'likes as likes_count' => function ($likes) {
                                        $likes->where('is_dislike', 0);
                                    },
                                    'likes as dislikes_count' => function ($likes) {
                                        $likes->where('is_dislike', 1);
                                    }
                                ]
                            );
                        },
                        'assemblables.type',
                        'assemblables_has_profile.profile' => function ($profile) {
                            $profile->withCount(
                                [
                                    // 'likes as likes_total',
                                    'likes as likes_count' => function ($likes) {
                                        $likes->where('is_dislike', 0);
                                    },
                                    'likes as dislikes_count' => function ($likes) {
                                        $likes->where('is_dislike', 1);
                                    }
                                ]
                            );
                        },
                        'assemblables_has_profile.type',
                        'posts' => function (HasMany $posts) {
                            $posts->published_posts();
                        },
                        'profile',
                    ]
                )
                ->withCount(
                    relations: [
                        'assemblables',
                        'assemblables_has_profile',
                        'posts' => function (PostQueryBuilder $posts) {
                            $posts->published_posts();
                        },
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
