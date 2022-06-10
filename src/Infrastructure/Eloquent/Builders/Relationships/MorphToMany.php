<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Relationships;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne as EloquentMorphOne;
use Infrastructure\Eloquent\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany as EloquentMorphToMany;
use Infrastructure\Eloquent\Builders\Relationships\Concerns\AbstractRelationships;

final class MorphToMany extends AbstractRelationships
{
    public function __invoke(Builder $query, array $relationships, bool $hasProfile = false): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships, $hasProfile) {
                foreach ($relationships as $relationship => $value) {
                    $show = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (in_array('show', $relationships[$relationship])) {
                            $show = true;
                        }
                        if (in_array('unpublished', $relationships[$relationship])) {
                            $published = false;
                        }
                    }
                    $model->when(
                        $show === true,
                        fn (Builder $model) =>
                        $model
                            ->when(
                                !$hasProfile,
                                fn () =>
                                $model
                                    ->with(
                                        relations: [
                                            (string)$relationship =>
                                            fn (EloquentMorphToMany $childRelationship) =>
                                            $childRelationship->published($published)
                                                ->withCount($this::likesCount()),
                                        ],
                                    ),
                                fn () =>
                                $model
                                    ->with(
                                        relations: [
                                            (string)$relationship =>
                                            fn (EloquentMorphToMany $childRelationship) =>
                                            $childRelationship->published($published),
                                            (string)$relationship . '.profile' =>
                                            function (EloquentMorphOne $profile) use ($published) {
                                                $profile->published($published)->withCount($this::likesCount());
                                                // $profile->with('type'); //NOTE
                                            },
                                        ],
                                    )
                            )
                            ->with(
                                relations: [
                                    (string)$relationship . '.type',
                                ],
                            )
                            ->withCount(
                                relations: [
                                    (string)$relationship
                                    =>
                                    // TODO: Move CustomQueryBuilder to Builder folder.
                                    fn (CustomQueryBuilder $childRelationship) =>
                                    $childRelationship->published($published),
                                ]
                            )
                    );
                }
            }
        );
    }
}
