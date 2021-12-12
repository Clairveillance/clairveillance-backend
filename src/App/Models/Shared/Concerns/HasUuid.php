<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    // NOTE: We generate a random and unique 'uuid' everytime we create a new User.
    public static function bootHasUuid(): void
    {
        static::creating(fn (Model $model) => $model->uuid = Str::uuid());
    }
}
