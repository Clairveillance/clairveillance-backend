<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post\Post;
use App\Models\User\User;
use App\Models\Post\PostType;
use Illuminate\Database\Seeder;
use Database\Seeders\Concerns\LikeSeederService;

final class PostSeeder extends Seeder
{
    public function __construct(public LikeSeederService $LikeSeederService)
    {
    }

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
                callback: function (Post $post) {
                    $post_types = PostType::where('created_at', '<=', $post->created_at)->get();
                    $post->post_type_uuid = $post_types->random()->uuid;
                    $users = User::where('created_at', '<=', $post->created_at)->get();
                    $post->user()->associate($users->random())->save();
                    $this->LikeSeederService->setUsers($users);
                    $this->LikeSeederService->setModel($post);
                    $this->LikeSeederService->save();
                }
            );
        dump(__METHOD__ . ' [success]');
    }
}
