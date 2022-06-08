<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Infrastructure\Models\User\User;
use Domain\User\ValueObjects\UserValueObject;

final class UpdateUserAction
{
    public static function handle(UserValueObject $object, User $user): bool
    {
        return $user->update(attributes: $object->toArray());
    }
}
