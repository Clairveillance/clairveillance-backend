<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        User::factory()->create([
            'username' => env('DEFAULT_USERNAME', $faker->userName()),
            'firstname' => env('DEFAULT_FIRSTNAME', $faker->firstName()),
            'lastname' => env('DEFAULT_LASTNAME', $faker->lastName()),
            'email' => env('DEFAULT_EMAIL', $faker->unique()->safeEmail()),
            'password' => Hash::make(env('DEFAULT_PASSWORD', $faker->word()), ),
        ]);
    }
}
