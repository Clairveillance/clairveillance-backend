<?php

declare(strict_types=1);

namespace Domain\Core\V1\Users\Actions\Commands;

use Infrastructure\Eloquent\Models\User\User;
use Domain\Core\V1\Users\Types\Entities\UserEntity;

final class UpdateUserAction
{
    public static function handle(UserEntity $object, User $user): bool
    {
        return $user->update(attributes: $object->toArray());
    }
}
