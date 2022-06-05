<?php

declare(strict_types=1);

namespace App\Core\Repositories\Api\V1\Shared\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasRelationships
{
    public static function morphOne(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $show = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['show'])) {
                            $show = $relationships[$relationship]['show'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $show === true,
                        fn (Builder $model) =>
                        $model->with(
                            relations: [
                                (string)$relationship =>
                                fn (MorphOne $relationship) =>
                                $relationship
                                    ->published($published)
                                    ->withCount(self::likesCount()),
                                // (string)$relationship . '.type', //NOTE
                            ]
                        )
                    );
                }
            }
        );
    }

    public static function hasManyCount(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $count = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['count'])) {
                            $count = $relationships[$relationship]['count'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $count === true,
                        fn (Builder $model) =>
                        $model->withCount(
                            relations: [
                                $relationship =>
                                fn (CustomQueryBuilder $relationship) =>
                                $relationship->published($published),
                            ]
                        )
                    );
                }
            }
        );
    }

    public static function hasMany(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $show = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['show'])) {
                            $show = $relationships[$relationship]['show'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $show === true,
                        fn (Builder $model) =>
                        $model
                            ->with(
                                relations: [
                                    (string)$relationship =>
                                    fn (HasMany $relationship) =>
                                    $relationship->published($published)
                                        ->withCount(self::likesCount()),
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
        );
    }

    public static function morphToManyCount(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $count = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['count'])) {
                            $count = $relationships[$relationship]['count'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $count === true,
                        fn (Builder $model) =>
                        $model->withCount(
                            relations: [
                                $relationship =>
                                fn (CustomQueryBuilder $relationship) =>
                                $relationship->published($published),
                            ]
                        )
                    );
                }
            }
        );
    }

    public static function morphToMany(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $show = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['show'])) {
                            $show = $relationships[$relationship]['show'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $show === true,
                        fn (Builder $model) =>
                        $model
                            ->with(
                                relations: [
                                    (string)$relationship =>
                                    fn (MorphToMany $relationship) =>
                                    $relationship
                                        ->published($published)
                                        ->withCount(self::likesCount()),
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
        );
    }

    public static function morphToManyHasProfileCount(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $count = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['count'])) {
                            $count = $relationships[$relationship]['count'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $count === true,
                        fn (Builder $model) =>
                        $model->withCount(
                            relations: [
                                (string)$relationship =>
                                fn (CustomQueryBuilder $relationship) =>
                                $relationship->published($published),
                            ]
                        )
                    );
                }
            }
        );
    }

    public static function morphToManyHasProfile(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $show = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (isset($relationships[$relationship]['show'])) {
                            $show = $relationships[$relationship]['show'] === 1 ? true : false;
                        }
                        if (isset($relationships[$relationship]['published'])) {
                            $published = $relationships[$relationship]['published'] === 0 ? false : true;
                        }
                    }
                    $model->when(
                        $show === true,
                        fn (Builder $model) =>
                        $model
                            ->with(
                                relations: [
                                    (string)$relationship =>
                                    fn (MorphToMany $relationship) =>
                                    $relationship->published($published),
                                    (string)$relationship . '.profile' =>
                                    function (MorphOne $profile) {
                                        $profile->withCount(self::likesCount());
                                        // $profile->with('type'); //NOTE
                                    },
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
        );
    }

    private static function likesCount(): array
    {
        return
            [
                // 'likes as likes_total', //NOTE
                'likes as likes_count' => fn (Builder $likes) => $likes->where('is_dislike', 0),
                'likes as dislikes_count' => fn (Builder $likes) => $likes->where('is_dislike', 1),
            ];
    }
}
