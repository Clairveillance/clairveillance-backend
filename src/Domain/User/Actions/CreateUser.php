<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Domain\User\Models\User;
use Domain\User\ValueObjects\UserValueObject;

class CreateUser
{
    public static function handle(UserValueObject $object): User
    {
        return User::create($object->toArray());
    }
}
