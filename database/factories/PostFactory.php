<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(
            nb: rand(
                min: 1,
                max: 7
            ),
            asText: true
        );
        $created_date = $this->faker->dateTimeBetween(User::oldest()->first()->created_at, now());
        $updated_date = $this->faker->dateTimeBetween($created_date, now());
        $published = $this->faker->boolean();

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'image' => $this->faker->randomElement([null, $this->faker->imageUrl(80, 80, null, false, $this->faker->word(), false)]),
            'description' => $this->faker->randomElement([null, $this->faker->sentence(random_int(1, 25))]),
            'body' => $this->faker->randomHtml(),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
            'published' => $published,
            'published_at' => ! $published ? null : $this->faker->dateTimeBetween($created_date, $updated_date),
        ];
    }
}
