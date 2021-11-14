<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $created_date = $this->faker->dateTimeBetween('-5 years', now());
        $updated_date = $this->faker->dateTimeBetween($created_date, now());
        $address = $this->faker->randomElement([null, $this->faker->streetAddress()]);

        return [
            'uuid' => $this->faker->uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'avatar' => $this->faker->randomElement([null, $this->faker->imageUrl()]),
            'description' => $this->faker->randomElement([null, $this->faker->sentence(random_int(1, 25))]),
            'company' => $this->faker->randomElement([null, $this->faker->company()]),
            'website' => $this->faker->randomElement([null, $this->faker->url()]),
            'country' => $this->faker->country(),
            'state' => $this->faker->randomElement([null, $this->faker->region()]),
            'city' => $this->faker->randomElement([null, $this->faker->city()]),
            'zip' => $this->faker->randomElement([null, $this->faker->buildingNumber()]),
            'address' => $address,
            'address_2' => $address ? $this->faker->randomElement([null, $this->faker->streetAddress()]) : null,
            'phone' => $this->faker->randomElement([null, $this->faker->phoneNumber()]),
            'theme' => $this->faker->randomElement([null, $this->faker->randomElement(['light', 'dark'])]),
            'language' => $this->faker->randomElement([null, $this->faker->languageCode()]),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween($created_date, $updated_date)]),
            'password' => hash('sha256', $this->faker->word()),
            'remember_token' => $this->faker->randomElement([null, $this->faker->md5()]),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
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
