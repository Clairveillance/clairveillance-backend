<?php

declare(strict_types=1);

namespace App\Core\Factories;

use Domain\User\ValueObjects\UserValueObject;
use Illuminate\Support\Facades\Hash;

final class UserFactory
{
    public static function create(array $attributes): UserValueObject
    {
        return new UserValueObject(
            username: $attributes['username'],
            firstname: $attributes['firstname'],
            lastname: $attributes['lastname'],
            description: $attributes['description'],
            email: $attributes['email'],
            password: Hash::make($attributes['password']),
        );
    }
}
