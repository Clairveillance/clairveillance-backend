<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Factories;

use Domain\Core\V1\Users\Types\Entities\UserEntity;
use Illuminate\Support\Facades\Hash;

final class UserFactory
{
    public static function create(array $attributes): UserEntity
    {
        return new UserEntity(
            username: $attributes['username'],
            firstname: $attributes['firstname'],
            lastname: $attributes['lastname'],
            description: $attributes['description'],
            email: $attributes['email'],
            password: Hash::make($attributes['password']),
        );
    }
}
