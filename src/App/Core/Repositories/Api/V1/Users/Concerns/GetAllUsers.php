<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users\Concerns;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use App\Core\Resources\Api\V1\Users\UserCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Appointment\QueryBuilder\AppointmentQueryBuilder;

abstract class GetAllUsers
{
    public static function withRelationsPaginated(
        string $orderBy,
        string $orderDirection,
        int $perPage
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
                        'assemblables' =>
                        fn (MorphToMany $assemblables) =>
                        $assemblables->withCount(
                            [
                                // 'likes as likes_total', //NOTE
                                'likes as likes_count' =>
                                fn (Builder $likes)
                                => $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes)
                                => $likes->where('is_dislike', 1),
                            ]
                        ),
                        'assemblables.type',
                        'assemblables_has_profile.profile' =>
                        fn (MorphOne $profile) =>
                        $profile->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'assemblables_has_profile.type',
                        'assignables' =>
                        fn (MorphToMany $assignables) =>
                        $assignables->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'assignables.type',
                        'assignables_has_profile.profile' =>
                        fn (MorphOne $profile) =>
                        $profile->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'assignables_has_profile.type',
                        'assignables' =>
                        fn (MorphToMany $establishables) =>
                        $establishables->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'establishables.type',
                        'establishables_has_profile.profile' =>
                        fn (MorphOne $profile) =>
                        $profile->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'establishables_has_profile.type',
                        'appointables' =>
                        fn (MorphToMany $appointments) =>
                        $appointments
                            ->published()
                            ->withCount(
                                [
                                    'likes as likes_count' =>
                                    fn (Builder $likes) =>
                                    $likes->where('is_dislike', 0),
                                    'likes as dislikes_count' =>
                                    fn (Builder $likes) =>
                                    $likes->where('is_dislike', 1),
                                ]
                            ),
                        'appointables.type',
                        'appointables_has_profile' =>
                        fn (MorphToMany $appointables) =>
                        $appointables->published(),
                        'appointables_has_profile.profile' =>
                        fn (MorphOne $profile) =>
                        $profile->withCount(
                            [
                                'likes as likes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 0),
                                'likes as dislikes_count' =>
                                fn (Builder $likes) =>
                                $likes->where('is_dislike', 1),
                            ]
                        ),
                        'appointables_has_profile.type',
                        'posts' =>
                        fn (HasMany $posts) =>
                        $posts->published(),
                        'profile' =>
                        fn (MorphOne $profile) =>
                        $profile,
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
                        'appointables' =>
                        fn (AppointmentQueryBuilder $appointables) =>
                        $appointables->published(),
                        'appointables_has_profile' =>
                        fn (AppointmentQueryBuilder $appointables) =>
                        $appointables->published(),
                        'posts' =>
                        fn (PostQueryBuilder $posts) =>
                        $posts->published(),
                    ]
                )
                // ->withTrashed() //NOTE
                // ->onlyTrashed() //NOTE
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
