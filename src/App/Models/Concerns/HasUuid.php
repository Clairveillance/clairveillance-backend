<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    // NOTE: We generate a random and unique 'uuid' everytime we create a new User.
    public static function bootHasUuid(): void
    {
        static::creating(fn (Model $model) => $model->uuid = Str::uuid());
    }
}
