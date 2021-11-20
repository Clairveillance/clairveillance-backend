<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

final class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        $initial_firstname = mb_substr($firstname, 0, 1);
        $initial_lastname = mb_substr($lastname, 0, 1);
        $created_date = $this->faker->dateTimeBetween('-5 years', now());
        $updated_date = $this->faker->dateTimeBetween($created_date, now());
        $address = $this->faker->randomElement([null, $this->faker->streetAddress()]);
        $state = match (env('APP_FAKER_LOCALE')) {
            'fr_FR' => $this->faker->region(),
            'en_US' => $this->faker->state(),
        };

        return [
            'uuid' => $this->faker->uuid(),
            'username' => $this->faker->unique()->userName(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'avatar' => $this->faker->randomElement([null, $this->faker->imageUrl(80, 80, null, false, strtoupper($initial_firstname . "\u{0020}" . $initial_lastname))]),
            'description' => $this->faker->randomElement([null, $this->faker->sentence(random_int(1, 25))]),
            'company' => $this->faker->randomElement([null, $this->faker->company()]),
            'website' => $this->faker->randomElement([null, $this->faker->url()]),
            'country' => $this->faker->country(),
            'state' => $this->faker->randomElement([null, $state]),
            'city' => $this->faker->randomElement([null, $this->faker->city()]),
            'zip' => $this->faker->randomElement([null, $this->faker->postcode()]),
            'address' => $address,
            'address_2' => $address ? $this->faker->randomElement([null, $this->faker->streetAddress()]) : null,
            'phone' => $this->faker->randomElement([null, $this->faker->phoneNumber()]),
            'theme' => $this->faker->randomElement([null, $this->faker->randomElement(['light', 'dark'])]),
            'language' => $this->faker->randomElement([null, $this->faker->languageCode()]),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make($this->faker->word()),
            'remember_token' => $this->faker->randomElement([null, $this->faker->md5()]),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
            'email_verified_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween($created_date, $updated_date)]),
        ];
    }

    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
