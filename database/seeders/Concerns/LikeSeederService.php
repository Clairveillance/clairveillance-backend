<?php

declare(strict_types=1);

namespace Database\Seeders\Concerns;

use App\Models\Like\Like;
use App\Models\Image\Image;
use App\Models\Like\LikeType;
use App\Models\Image\ImageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * LikeSeederService
 * 
 * @property Model $model
 * @property Collection $users
 * @method setModel
 * @method setUsers
 * @method save
 */
final class LikeSeederService
{
    private Model $model;
    private Collection $users;

    /**
     * setModel
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setModel(Model $model): Model
    {
        return $this->model = $model;
    }

    /**
     * setUsers
     *
     * @param  \Illuminate\Support\Collection $users
     * @return \Illuminate\Support\Collection
     */
    public function setUsers(Collection $users): Collection
    {
        return $this->users = $users;
    }

    /**
     * save
     *
     * @return void
     */
    public function save(): void
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
        for ($i = 0; $i < rand(1, 200); $i++) {
            try {
                $like  = new Like();
                $like->is_dislike = rand(1, 10) > 1 ? 0 : 1;
                $like->user()->associate($users->random())
                    ->type()->associate($likeType)
                    ->likeable()->associate($model->profile)
                    ->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
