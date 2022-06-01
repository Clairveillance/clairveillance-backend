<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use App\Models\Establishment\EstablishmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AbstractEstablishmentFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique(
            reset: false,
            maxRetries: 10000
        )->words(
            nb: rand(
                min: 2,
                max: 6
            ),
            asText: true
        );
        $created_date = $this->faker->dateTimeBetween(
            startDate: EstablishmentType::oldest()->first()->created_at,
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
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 5
                    ),
                    variableNbWords: true
                )]
            ),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
        ];
    }
}
