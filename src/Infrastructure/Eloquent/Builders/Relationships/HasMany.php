<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Relationships;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany as EloquentHasMany;
use Infrastructure\Eloquent\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Infrastructure\Eloquent\Builders\Relationships\Concerns\AbstractRelationships;

final class HasMany extends AbstractRelationships
{
    public function __invoke(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
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
                            ->with(
                                relations: [
                                    (string)$relationship =>
                                    fn (EloquentHasMany $childRelationship) =>
                                    $childRelationship->published($published)
                                        ->withCount($this::likesCount()),
                                    (string)$relationship . '.type',
                                ]
                            )
                            ->withCount(
                                relations: [
                                    (string)$relationship =>
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
