<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post\Post;
use App\Models\Post\PostType;
use App\Models\User\User;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(1000)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($post) {
                    $users = User::where('created_at', '<', $post->created_at)->get();
                    $post_types = PostType::all();
                    $post->author_uuid = $users->random()->uuid;
                    $post->post_type_uuid = $post_types->random()->uuid;
                    $post->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
