<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Users\Concerns;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use App\Core\Resources\Api\V1\Users\UserCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Shared\QueryBuilders\CustomQueryBuilder;

abstract class GetAllUsers
{
    public static function withRelations(
        int $perPage,
        string $orderBy,
        string $orderDirection,
        array $morphOneRelationships,
        array $hasManyRelationships,
        array $morphToManyRelationships,
        array $morphToManyRelationshipsHasProfile,
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
                ->when(
                    $morphOneRelationships,
                    function (Builder $user) use ($morphOneRelationships) {
                        foreach ($morphOneRelationships as $relationship => $value) {
                            $visible = false;
                            $published = true;
                            if ($morphOneRelationships[$relationship]) {
                                if (isset($morphOneRelationships[$relationship]['visible'])) {
                                    $visible = $morphOneRelationships[$relationship]['visible'] === 1 ? true : false;
                                }
                                if (isset($morphOneRelationships[$relationship]['published'])) {
                                    $published = $morphOneRelationships[$relationship]['published'] === 0 ? false : true;
                                }
                            }
                            $user->when(
                                $visible === true,
                                fn (Builder $user) =>
                                $user->with(
                                    relations: [
                                        (string)$relationship =>
                                        fn (MorphOne $relationship) =>
                                        $relationship
                                            // ->published($published) //TODO
                                            ->withCount(
                                                [
                                                    'likes as likes_total',
                                                    'likes as likes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 0),
                                                    'likes as dislikes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 1),
                                                ]
                                            ),
                                        (string)$relationship . '.type',
                                    ]
                                )
                            );
                        }
                    }
                )
                ->when(
                    $hasManyRelationships,
                    function (Builder $user) use ($hasManyRelationships) {
                        foreach ($hasManyRelationships as $relationship => $value) {
                            $visible = false;
                            $published = true;
                            if ($hasManyRelationships[$relationship]) {
                                if (isset($hasManyRelationships[$relationship]['visible'])) {
                                    $visible = $hasManyRelationships[$relationship]['visible'] === 1 ? true : false;
                                }
                                if (isset($hasManyRelationships[$relationship]['published'])) {
                                    $published = $hasManyRelationships[$relationship]['published'] === 0 ? false : true;
                                }
                            }
                            $user->when(
                                $visible === true,
                                fn (Builder $user) =>
                                $user->with(
                                    relations: [
                                        (string)$relationship =>
                                        fn (HasMany $relationship) =>
                                        $relationship->published($published)
                                            ->withCount(
                                                [
                                                    'likes as likes_total',
                                                    'likes as likes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 0),
                                                    'likes as dislikes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 1),
                                                ]
                                            ),
                                        (string)$relationship . '.type',
                                    ]
                                )
                                    ->withCount(
                                        relations: [
                                            $relationship =>
                                            fn (CustomQueryBuilder $relationship) =>
                                            $relationship->published($published),
                                        ]
                                    )
                            );
                        }
                    }
                )
                ->when(
                    $morphToManyRelationships,
                    function (Builder $user) use ($morphToManyRelationships) {
                        foreach ($morphToManyRelationships as $relationship => $value) {
                            $visible = false;
                            $published = true;
                            if ($morphToManyRelationships[$relationship]) {
                                if (isset($morphToManyRelationships[$relationship]['visible'])) {
                                    $visible = $morphToManyRelationships[$relationship]['visible'] === 1 ? true : false;
                                }
                                if (isset($morphToManyRelationships[$relationship]['published'])) {
                                    $published = $morphToManyRelationships[$relationship]['published'] === 0 ? false : true;
                                }
                            }
                            $user->when(
                                $visible === true,
                                fn (Builder $user) =>
                                $user->with(
                                    relations: [
                                        (string)$relationship =>
                                        fn (MorphToMany $relationship) =>
                                        $relationship
                                            ->published($published)
                                            ->withCount(
                                                [
                                                    'likes as likes_total',
                                                    'likes as likes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 0),
                                                    'likes as dislikes_count' =>
                                                    fn (Builder $likes)
                                                    => $likes->where('is_dislike', 1),
                                                ]
                                            ),
                                        (string)$relationship . '.type',
                                    ],
                                )
                                    ->withCount(
                                        relations: [
                                            $relationship =>
                                            fn (CustomQueryBuilder $relationship) =>
                                            $relationship->published($published),
                                        ]
                                    )
                            );
                        }
                    }
                )
                ->when(
                    $morphToManyRelationshipsHasProfile,
                    function (Builder $user) use ($morphToManyRelationshipsHasProfile) {
                        foreach ($morphToManyRelationshipsHasProfile as $relationship => $value) {
                            $visible = false;
                            $published = true;
                            if ($morphToManyRelationshipsHasProfile[$relationship]) {
                                if (isset($morphToManyRelationshipsHasProfile[$relationship]['visible'])) {
                                    $visible = $morphToManyRelationshipsHasProfile[$relationship]['visible'] === 1 ? true : false;
                                }
                                if (isset($morphToManyRelationshipsHasProfile[$relationship]['published'])) {
                                    $published = $morphToManyRelationshipsHasProfile[$relationship]['published'] === 0 ? false : true;
                                }
                            }
                            $user->when(
                                $visible === true,
                                fn (Builder $user) =>
                                $user->with(
                                    relations: [
                                        (string)$relationship =>
                                        fn (MorphToMany $relationship) =>
                                        $relationship->published($published),
                                        $relationship . '.profile' =>
                                        fn (MorphOne $profile) =>
                                        $profile->withCount(
                                            [
                                                'likes as likes_total',
                                                'likes as likes_count' =>
                                                fn (Builder $likes)
                                                => $likes->where('is_dislike', 0),
                                                'likes as dislikes_count' =>
                                                fn (Builder $likes)
                                                => $likes->where('is_dislike', 1),
                                            ]
                                        ),
                                        (string)$relationship . '.type',
                                    ]
                                )
                                    ->withCount(
                                        relations: [
                                            (string)$relationship =>
                                            fn (CustomQueryBuilder $relationship) =>
                                            $relationship->published($published),
                                        ]
                                    )
                            );
                        }
                    }
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
