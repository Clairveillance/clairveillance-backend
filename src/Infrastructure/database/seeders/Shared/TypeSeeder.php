<?php

declare(strict_types=1);

namespace Database\Seeders\Shared;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * TypeSeeder
 *
 * @property Model $model
 * @property array<string,string> $attributes
 * @method setModel
 * @method run
 */
final class TypeSeeder extends Seeder
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private Model $model;

    /** @var array<string,string> */
    private array $attributes;

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
     * setAttributes
     *
     * @param  array<string,string> $attributes
     * @return \Database\Seeders\Shared\TypeSeeder
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

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
            $model::factory(rand(1, 15))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Model $model) {
                        if (isset($this->attributes)) {
                            if (in_array('image_uuid', $this->attributes)) {
                                $model->image_uuid = $this->attributes['image_uuid'];
                            }
                        }
                        $model->save();
                    }
                );
        } catch (\Throwable $e) {
        }
    }
}
