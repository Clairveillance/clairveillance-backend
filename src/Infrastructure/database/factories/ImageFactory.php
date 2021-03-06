<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Eloquent\Models\Image\Image;
use Infrastructure\Eloquent\Models\Image\ImageType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        $name = $this->faker->unique(
            reset: false,
            maxRetries: 10000
        )->words(
            nb: rand(
                min: 1,
                max: 10
            ),
            asText: true
        );
        $created_date = $this->faker->dateTimeBetween(
            startDate: ImageType::oldest()->first()->created_at,
            endDate: now(
                tz: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
            timezone: env(
                key: 'APP_TIMEZONE',
                default: 'UTC'
            )
        );
        $updated_date = $this->faker->dateTimeBetween(
            startDate: $created_date,
            endDate: now(
                tz: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
            timezone: env(
                key: 'APP_TIMEZONE',
                default: 'UTC'
            )
        );

        return [
            'name' => $name,
            'created_at' => $created_date,
            'updated_at' => $updated_date,
        ];
    }
}
