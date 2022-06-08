<?php

declare(strict_types=1);

namespace Infrastructure\Models\Shared\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    abstract public function slugSources(): array;

    // NOTE: We generate a slug everytime we create a new Model using this Trait.
    // The source of the slug is defined in the Model::class using the slugSources() function.
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $params = '';
            extract($model->slugSources());
            $slug = $model->$source . $params;
            $model->slug = Str::slug($slug);
        });
    }
}
