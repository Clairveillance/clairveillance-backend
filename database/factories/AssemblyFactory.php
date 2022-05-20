<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class AssemblyFactory extends Factory
{
    protected $model = Assembly::class;

    public function definition(): array
    {
        $title = $this->faker->unique(
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

        return [
            'slug' => Str::slug(
                title: $title,
                separator: '-',
                language: env(
                    key: 'APP_LOCALE',
                    default: 'en'
                ),
            ),
            'title' => $title,
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 25
                    ),
                    variableNbWords: true
                )]
            ),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
        ];
    }
}
