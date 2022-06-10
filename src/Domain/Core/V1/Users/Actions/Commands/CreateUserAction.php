<?php

declare(strict_types=1);

namespace Domain\Core\V1\Users\Actions\Commands;

use Infrastructure\Models\User\User;
use Domain\Core\V1\Users\Types\Entities\UserEntity;

final class CreateUserAction
{
    public static function handle(UserEntity $object): User
    {
        return User::create($object->toArray());
    }
}
