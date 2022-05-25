<?php

declare(strict_types=1);

namespace Database\Seeders\Shared;

use App\Models\Like\Like;
use App\Models\Image\Image;
use App\Models\Like\LikeType;
use App\Models\Image\ImageType;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * LikeSeeder
 * 
 * @property Model $model
 * @property Collection $users
 * @method setModel
 * @method setUsers
 * @method run
 */
final class LikeSeeder
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private Model $model;

    /** @var \Illuminate\Support\Collection */
    private Collection $users;

    /**
     * setModel
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Database\Seeders\Shared\LikeSeeder
     */
    public function setModel(Model $model): LikeSeeder
    {
        $this->model = $model;
        return $this;
    }

    /**
     * setUsers
     *
     * @param  \Illuminate\Support\Collection $users
     * @return \Database\Seeders\Shared\LikeSeeder
     */
    public function setUsers(Collection $users): LikeSeeder
    {
        $this->users = $users;
        return $this;
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
        $likeTypeImageType = ImageType::where('name', 'likeable images')->first();
        if (!$likeTypeImageType) {
            $likeTypeImageType = new ImageType(['name' => 'likeable images']);
            $likeTypeImageType->save();
        }
        $likeTypeImage = Image::where('name', 'heart')->first();
        if (!$likeTypeImage) {
            $likeTypeImage = new Image([
                'name' => 'heart',
                'type' => 'jpg',
                'size' => '127198271',
                'description' => 'Just a simple heart',
            ]);
            $likeTypeImage->user()->associate($users->random())
                ->type()->associate($likeTypeImageType)
                ->save();
        }
        $likeType = LikeType::where('name', 'heart')->first();
        if (!$likeType) {
            $likeType = new LikeType(['name' => 'heart']);
            $likeType->image()->associate($likeTypeImage)->save();
        }
        for ($i = 0; $i < rand(0, 20); $i++) {
            try {
                $like  = new Like();
                $like->is_dislike = rand(1, 10) > 1 ? 0 : 1;
                $like->user()->associate($users->random())
                    ->type()->associate($likeType)
                    ->likeable()->associate($model)
                    ->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}