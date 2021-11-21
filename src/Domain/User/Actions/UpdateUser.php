<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Domain\User\Models\User;
use Domain\User\ValueObjects\UserValueObject;

final class UpdateUser
{
    public static function handle(UserValueObject $object, User $user): bool
    {
        return $user->update($object->toArray());
    }
}
