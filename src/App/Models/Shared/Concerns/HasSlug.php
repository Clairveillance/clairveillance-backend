<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    // NOTE: We generate a slug everytime we create a new Model using this Trait.
    // The source of the slug is defined in the Model::class using the slugSource() function.
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $source = $model->slugSource();
            $model->slug = Str::slug($source['source']);
        });
    }

    abstract public function slugSource(): array;
}
