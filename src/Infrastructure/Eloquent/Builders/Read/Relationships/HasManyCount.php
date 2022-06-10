<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Builders\Read\Relationships;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Eloquent\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Infrastructure\Eloquent\Builders\Read\Relationships\Concerns\AbstractRelationships;

final class HasManyCount extends AbstractRelationships
{
    public function __invoke(Builder $query, array $relationships): Builder
    {
        return $query->when(
            $relationships,
            function (Builder $model) use ($relationships) {
                foreach ($relationships as $relationship => $value) {
                    $count = false;
                    $published = true;
                    if ($relationships[$relationship]) {
                        if (in_array('count', $relationships[$relationship])) {
                            $count = true;
                        }
                        if (in_array('unpublished', $relationships[$relationship])) {
                            $published = false;
                        }
                    }
                    $model->when(
                        $count === true,
                        fn (Builder $model) =>
                        $model->withCount(
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
