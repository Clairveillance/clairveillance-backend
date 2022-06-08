<?php

declare(strict_types=1);

namespace Database\Factories;

use Infrastructure\Models\Post\Post;
use Infrastructure\Models\Post\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->unique(
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
            startDate: PostType::oldest()->first()->created_at,
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
        $published = $this->faker->boolean(
            chanceOfGettingTrue: 80
        );

        return [
            'title' => $title,
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 5
                    ),
                    variableNbWords: true
                )]
            ),
            'body' => $this->faker->randomHtml(
                maxDepth: 4,
                maxWidth: 4
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
