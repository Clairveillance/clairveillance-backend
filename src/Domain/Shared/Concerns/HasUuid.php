<?php

declare(strict_types=1);

namespace Domain\Shared\Concerns;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        $faker = Factory::create();
        static::creating(fn (Model $model) => $model->uuid = $faker->unique()->uuid());
    }
}
