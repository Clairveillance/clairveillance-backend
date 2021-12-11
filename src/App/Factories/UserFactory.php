<?php

declare(strict_types=1);

namespace App\Factories;

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
            avatar: $attributes['avatar'],
            description: $attributes['description'],
            company: $attributes['company'],
            website: $attributes['website'],
            country: $attributes['country'],
            state: $attributes['state'],
            city: $attributes['city'],
            zip: $attributes['zip'],
            address: $attributes['address'],
            address_2: $attributes['address_2'],
            phone: $attributes['phone'],
            theme: $attributes['theme'],
            language: $attributes['language'],
            email: $attributes['email'],
            password: Hash::make($attributes['password']),
        );
    }
}
