<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $published = $this->faker->boolean(
            chanceOfGettingTrue: 50
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
            'image' => $this->faker->randomElement(
                array: [null, $this->faker->imageUrl(
                    width: 80,
                    height: 80,
                    category: null,
                    randomize: false,
                    word: $this->faker->word(),
                    gray: false
                )]
            ),
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 25
                    ),
                    variableNbWords: true
                )]
            ),
            'body' => $this->faker->randomHtml(
                maxDepth: 4,
                maxWidth: 4
            ),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
            'published' => $published,
            'published_at' => ! $published ? null : $this->faker->dateTimeBetween(
                startDate: $created_date,
                endDate: $updated_date,
                timezone: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
        ];
    }
}
