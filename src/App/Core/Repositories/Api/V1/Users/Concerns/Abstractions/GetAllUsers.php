<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users\Concerns\Abstractions;

use App\Models\User\User;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Core\Resources\Api\V1\Users\UserCollection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Appointment\QueryBuilder\AppointmentQueryBuilder;

abstract class GetAllUsers
{
    abstract function getAllUsers(): UserCollection;

    /**
     * withRelationsPaginated
     *
     * @param string $orderBy
     * @param string $orderDirection
     * @param int $perPage
     * @return \App\Core\Resources\Api\V1\Users\UserCollection
     */
    protected static function withRelationsPaginated(
        string $orderBy = 'username',
        string $orderDirection = 'asc',
        int $perPage = 25
    ): UserCollection {
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
                        'assignables' => function (MorphToMany $assignables) {
                            $assignables->withCount(
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
                        'assignables.type',
                        'assignables_has_profile.profile' => function ($profile) {
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
                        'assignables_has_profile.type',
                        'assignables' => function (MorphToMany $establishables) {
                            $establishables->withCount(
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
                        'establishables.type',
                        'establishables_has_profile.profile' => function ($profile) {
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
                        'establishables_has_profile.type',
                        'appointables' => function (MorphToMany $appointments) {
                            $appointments
                                ->published()
                                ->withCount(
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
                        'appointables.type',
                        'appointables_has_profile' => function (MorphToMany $appointables) {
                            $appointables->published();
                        },
                        'appointables_has_profile.profile' => function ($profile) {
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
                        'appointables_has_profile.type',
                        'posts' => function (HasMany $posts) {
                            $posts->published();
                        },
                        'profile',
                    ]
                )
                ->withCount(
                    relations: [
                        'assemblables',
                        'assemblables_has_profile',
                        'assignables',
                        'assignables_has_profile',
                        'establishables',
                        'establishables_has_profile',
                        'appointables' => function (AppointmentQueryBuilder $appointables) {
                            $appointables->published();
                        },
                        'appointables_has_profile' => function (AppointmentQueryBuilder $appointables) {
                            $appointables->published();
                        },
                        'posts' => function (PostQueryBuilder $posts) {
                            $posts->published();
                        },
                    ]
                )
                // ->withTrashed()
                // ->onlyTrashed()
                ->orderBy(
                    column: $orderBy,
                    direction: $orderDirection
                )
                ->paginate(
                    perPage: $perPage,
                    columns: ['id'],
                    pageName: 'page',
                    page: null
                )
        );
        $users::$wrap = 'data';
        return $users;
    }
}
