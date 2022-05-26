<?php

declare(strict_types=1);

namespace Database\Seeders\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * TypeSeeder
 *
 * @property Model $model
 * @method setModel
 * @method run
 */
final class TypeSeeder extends Seeder
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private Model $model;

    /**
     * setModel
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Database\Seeders\Shared\TypeSeeder
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        $model = $this->model;
        try {
            $model::factory(rand(1, 20))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Model $model) {
                        $model->save();
                    }
                );
        } catch (\Throwable $e) {
        }
    }
}
