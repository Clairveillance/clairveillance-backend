<?php

declare(strict_types=1);

namespace Domain\Core\V1\Users\Actions;

use Infrastructure\Models\User\User;
use Domain\Core\V1\Users\ValueObjects\UserValueObject;

final class CreateUserAction
{
    public static function handle(UserValueObject $object): User
    {
        return User::create($object->toArray());
    }
}
