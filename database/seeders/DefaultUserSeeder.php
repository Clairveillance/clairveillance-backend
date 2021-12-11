<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create(
            locale: env(
                key: 'APP_FAKER_LOCALE',
                default: 'en_US'
            )
        );

        User::factory()->create(
            attributes: [
                'username' => env(
                    key: 'DEFAULT_USERNAME',
                    default: $faker->userName()
                ),
                'firstname' => env(
                    key: 'DEFAULT_FIRSTNAME',
                    default: $faker->firstName()
                ),
                'lastname' => env(
                    key: 'DEFAULT_LASTNAME',
                    default: $faker->lastName()
                ),
                'email' => env(
                    key: 'DEFAULT_EMAIL',
                    default: $faker->unique()->safeEmail()
                ),
                'password' => Hash::make(
                    value: env(
                        key: 'DEFAULT_PASSWORD',
                        default: $faker->word()
                    ),
                    options: [
                        //
                    ]
                ),
            ],
            parent: null
        );
    }
}
