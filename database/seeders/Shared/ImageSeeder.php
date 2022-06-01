<?php

declare(strict_types=1);

namespace Database\Seeders\Shared;

use App\Models\Image\Image;
use App\Models\Image\ImageType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Eloquent\Model;

/**
 * PostSeeder
 *
 * @property Model $model
 * @property Collection $users
 * @method setModel
 * @method setUsers
 * @method run
 */
final class ImageSeeder extends Seeder
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private Model $model;

    /** @var \Illuminate\Support\Collection */
    private Collection $users;

    /**
     * setModel
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Database\Seeders\Shared\ImageSeeder
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
     * @return \Database\Seeders\Shared\ImageSeeder
     */
    public function setUsers(Collection $users): self
    {
        $this->users = $users;
        return $this;
    }

    public function __construct(
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new ImageType)->run();
    }

    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        $errors = [];
        $model = $this->model;
        $users = $this->users;
        try {
            Image::factory(2)->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Image $image) use ($model, $users) {
                        $image_types = ImageType::where('created_at', '<=', $image->created_at)->get();
                        $image->user()->associate($users->random())
                            ->type()->associate($image_types->random())
                            ->save();
                        for ($i = 0; $i < rand(1, 5); $i++) {
                            try {
                                $models = $model::where('uuid', '!=', $model->uuid)->get();
                                if ($models->isNotEmpty()) {
                                    $imageable = $models->random();
                                    if (
                                        $image->imageables($model)->get()->isEmpty()
                                        ||
                                        !$image->imageables($model)->get()->contains($imageable)
                                    ) {
                                        $image->imageables($model)->attach($imageable);
                                    }
                                }
                            } catch (\Throwable $e) {
                            }
                        }
                    }
                );
        } catch (\Throwable $e) {
            if (empty($errors)) {
                $errors[] = true;
                dump(__METHOD__ . ' [error]');
            }
        }
    }
}
