<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AbstractTypeFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique(
            reset: false,
            maxRetries: 10000
        )->words(
            nb: rand(
                min: 1,
                max: 4
            ),
            asText: true
        );
        $created_date = $this->faker->dateTimeBetween(
            startDate: User::oldest()->first()->created_at,
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
