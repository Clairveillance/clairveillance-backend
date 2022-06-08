<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

use Infrastructure\Models\Assembly\AssemblyType;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AbstractAppointmentFactory extends Factory
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
            startDate: AssemblyType::oldest()->first()->created_at,
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
        $start_date = $this->faker->dateTimeBetween(
            startDate: $updated_date,
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
        $end_date = $this->faker->dateTimeBetween(
            startDate: $start_date,
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
        $published = $this->faker->boolean(
            chanceOfGettingTrue: 80
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
            'start_at' => $start_date,
            'end_at' => $end_date,
            'note' => $this->faker->randomElement(
                array: [null, $this->faker->paragraph(
                    nbSentences: random_int(
                        min: 1,
                        max: 5
                    ),
                    variableNbSentences: true
                )]
            ),
            'published' => $published,
            'published_at' => !$published ? null : $this->faker->dateTimeBetween(
                startDate: $created_date,
                endDate: $updated_date,
                timezone: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
        ];
    }
}
