<?php

declare(strict_types=1);

namespace App\Core\Observers;

use Infrastructure\Models\Profile\ProfileType;
use Infrastructure\Models\User\User;

final class UserObserver
{
    public function created(User $user): void
    {
        $type = ProfileType::firstOrCreate(['name' => $user->getMorphClass()]);
        $user->profile()->make([
            // IMPORTANT: Remove this when not using Seeders.
            'published' => (bool)true,
            'published_at' => now()
        ])
            ->user()->associate($user)
            ->type()->associate($type)
            ->save();
    }
}
