<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'avatar' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(random_int(1, 25)),
            'company' => $this->faker->company(),
            'website' => $this->faker->url(),
            'country' => $this->faker->country(),
            'state' => $this->faker->region(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->buildingNumber(),
            'address' => $this->faker->streetAddress(),
            'address_2' => $this->faker->streetAddress(),
            'phone' => $this->faker->phoneNumber(),
            'theme' => $this->faker->randomElement(['light', 'dark']),
            'language' => $this->faker->languageCode(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => hash('sha256', 'password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
