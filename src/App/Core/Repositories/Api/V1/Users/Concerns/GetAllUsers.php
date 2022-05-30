<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users\Concerns;

use App\Models\User\User;
use App\Core\Resources\UserCollection;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class GetAllUsers
{
    abstract function getAllUsers(): UserCollection;

    /**
     * withRelationsPaginated
     *
     * @return \App\Core\Resources\UserCollection
     */
    protected static function withRelationsPaginated(): UserCollection
    {
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
                ->paginate(
                    perPage: 15,
                    columns: ['id'],
                    pageName: 'page',
                    page: null
                )
        );
        $users::$wrap = 'data';
        return $users;
    }
}
