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
            $user = $model->user();
            $username = $user->username;
            $language = $user->language()->code ?? 'en';
            $source = $model->slugSource()['source'].'-'.$username;
            $model->slug = Str::slug($source, '-', $language);
        });
    }

    abstract public function slugSource(): array;
}
