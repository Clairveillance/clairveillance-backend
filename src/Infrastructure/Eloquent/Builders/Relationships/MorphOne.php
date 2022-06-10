<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Relationships;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne as EloquentMorphOne;
use Infrastructure\Eloquent\Builders\Relationships\Concerns\AbstractRelationships;

final class MorphOne extends AbstractRelationships
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
                        $model->with(
                            relations: [
                                (string)$relationship =>
                                fn (EloquentMorphOne $relationship) =>
                                $relationship
                                    ->published($published)
                                    ->withCount($this::likesCount()),
                                (string)$relationship . '.type',
                            ]
                        )
                    );
                }
            }
        );
    }
}
