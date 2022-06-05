<?php

declare(strict_types=1);

namespace App\Core\Observers;

use App\Models\Profile\ProfileType;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

final class ModelHasProfileObserver
{
    public function created(Model $model): void
    {
        $type = ProfileType::firstOrCreate(['name' => $model->getMorphClass()]);
        $model->profile()->make([
            // IMPORTANT: Remove this when not using Seeders.
            'published' => (bool)true,
            'published_at' => now()
        ])
            ->user()->associate(User::where('uuid', $model->user_uuid)->first())
            ->type()->associate($type)
            ->save();
    }
}
