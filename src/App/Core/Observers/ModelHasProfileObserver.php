<?php

declare(strict_types=1);

namespace App\Core\Observers;

use App\Models\User\User;
use App\Models\Profile\ProfileType;
use Illuminate\Database\Eloquent\Model;

final class ModelHasProfileObserver
{
    public function created(Model $model): void
    {
        $profileType = ProfileType::where('name', $model->getMorphClass())->first();
        if (!$profileType) {
            $profileType = new ProfileType();
            $profileType->name = $model->getMorphClass();
            $profileType->save();
        }
        $model->profile()->make([])
            ->user()->associate(User::where('uuid', $model->user_uuid)->first())
            ->type()->associate($profileType)
            ->save();
    }
}
