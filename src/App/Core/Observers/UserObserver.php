<?php

declare(strict_types=1);

namespace App\Core\Observers;

use App\Models\User\User;
use App\Models\Profile\ProfileType;

final class UserObserver
{
    public function created(User $user): void
    {
        $profileType = ProfileType::where('name', $user->getMorphClass())->first();
        if (!$profileType) {
            $profileType = new ProfileType();
            $profileType->name = $user->getMorphClass();
            $profileType->save();
        }
        $user->profile()->make([])
            ->user()->associate($user->uuid)
            ->type()->associate($profileType)
            ->save();
    }
}
