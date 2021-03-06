<?php

declare(strict_types=1);

namespace Database\Seeders\Shared;

use Infrastructure\Eloquent\Models\Post\Post;
use Infrastructure\Eloquent\Models\Post\PostType;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * PostSeeder
 *
 * @property Model $model
 * @property Collection $users
 * @method setModel
 * @method setUsers
 * @method run
 */
final class PostSeeder extends Seeder
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private Model $model;

    /** @var \Illuminate\Support\Collection */
    private Collection $users;

    /**
     * setModel
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Database\Seeders\Shared\PostSeeder
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * setUsers
     *
     * @param  \Illuminate\Support\Collection $users
     * @return \Database\Seeders\Shared\PostSeeder
     */
    public function setUsers(Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function __construct(
        public LikeSeeder $likeSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new PostType)->run();
    }

    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        $model = $this->model;
        $users = $this->users;
        try {
            Post::factory(rand(0, 5))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Post $post) use ($users, $model) {
                        $post_types = PostType::where('created_at', '<=', $post->created_at)->get();
                        $post->user()->associate($users->random())
                            ->type()->associate($post_types->random())
                            ->postable()->associate($model)->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($post)
                            ->run();
                    }
                );
        } catch (\Throwable $e) {
        }
    }
}
