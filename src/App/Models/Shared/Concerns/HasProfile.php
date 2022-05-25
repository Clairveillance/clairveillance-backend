<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns;

use App\Models\Profile\Profile;
use App\Models\Profile\ProfileType;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasProfile
{
    // NOTE: We generate a profile everytime we create a new Model using this Trait.
    // Once we generated the profile, we attach it to the Model::class using his profile() function.
    // We also need to associate the user_uuid of the Model and a ProfileType before saving the Profile.

    // FIXME: To prevent an error  when associating the user_uuid and while using php artisan db:seed command,
    // we had to set DB::statement('SET FOREIGN_KEY_CHECKS=0;') inside run() function of DatabaseSeeder.¨

    public static function bootHasProfile(): void
    {
        static::creating(function (Model $model) {
            $modelClass = $model::class;
            $profileType = ProfileType::where('name', $modelClass)->first();
            if (!$profileType) {
                $profileType = new ProfileType();
                $profileType->name = $modelClass;
                $profileType->save();
            }
            $profile = new Profile();
            $profile->profilable()->associate($model);
            // FIXME
            // $profile->user()->associate(
            //     match ($modelClass) {
            //         User::class => $model->uuid,
            //         default => $model->user_uuid
            //     }
            // );
            $profile->type()->associate($profileType);
            $profile->save();
        });
    }

    abstract public function profile(): MorphOne;
}
