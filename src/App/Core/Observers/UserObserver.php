<?php

declare(strict_types=1);

namespace App\Core\Observers;

use App\Models\Profile\ProfileType;
use App\Models\User\User;

final class UserObserver
{
    public function created(User $user): void
    {
        $type = ProfileType::firstOrCreate(['name' => $user->getMorphClass()]);
        $user->profile()->make([])
            ->user()->associate($user)
            ->type()->associate($type)
            ->save();
    }
}
