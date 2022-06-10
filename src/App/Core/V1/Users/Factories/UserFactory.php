<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Factories;

use Domain\Core\V1\Users\Types\Entities\UserEntity;
use Illuminate\Support\Facades\Hash;

final class UserFactory
{
    // TODO: Move to Domain layer.
    public static function create(array $attributes): UserEntity
    {
        return new UserEntity(
            username: $attributes['username'],
            firstname: $attributes['firstname'],
            lastname: $attributes['lastname'],
            description: $attributes['description'],
            email: $attributes['email'],
            // TODO: Make helper for password hash.
            password: Hash::make($attributes['password']),
        );
    }
}
