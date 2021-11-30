<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domain\Post\Models\Post;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(1000)->make()
            ->sortBy(function ($sort) {
                return $sort->created_at;
            })
            ->each(function ($post) {
                $users = User::where('created_at', '<', $post->created_at)->get();
                $post->author_uuid = $users->random()->uuid;
                $post->save();
            });
    }
}