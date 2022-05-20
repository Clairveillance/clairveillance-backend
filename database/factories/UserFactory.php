<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

final class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $firstname = $this->faker->firstName(
            gender: null
        );
        $lastname = $this->faker->lastName();
        $initial_firstname = mb_substr(
            string: $firstname,
            start: 0,
            length: 1
        );
        $initial_lastname = mb_substr(
            string: $lastname,
            start: 0,
            length: 1
        );
        $created_date = $this->faker->dateTimeBetween(
            startDate: '-5 years',
            endDate: now(
                tz: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
            timezone: env(
                key: 'APP_TIMEZONE',
                default: 'UTC'
            )
        );
        $updated_date = $this->faker->dateTimeBetween(
            startDate: $created_date,
            endDate: now(
                tz: env(
                    key: 'APP_TIMEZONE',
                    default: 'UTC'
                )
            ),
            timezone: env(
                key: 'APP_TIMEZONE',
                default: 'UTC'
            )
        );
        $address = $this->faker->randomElement(
            array: [null, $this->faker->streetAddress()]
        );
        $state = match (env(
            key: 'APP_FAKER_LOCALE',
            default: 'en_US'
        )) {
            'fr_FR' => $this->faker->region(),
            'en_US' => $this->faker->state(),
        };

        return [
            'username' => $this->faker->unique(
                reset: false,
                maxRetries: 10000
            )->userName(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'avatar' => $this->faker->randomElement(
                array: [null, $this->faker->imageUrl(
                    width: 80,
                    height: 80,
                    category: null,
                    randomize: false,
                    word: strtoupper(
                        string: $initial_firstname . "\u{0020}" . $initial_lastname
                    ),
                    gray: false
                )]
            ),
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 25
                    ),
                    variableNbWords: true
                )]
            ),
            'company' => $this->faker->randomElement(
                array: [null, $this->faker->company()]
            ),
            'website' => $this->faker->randomElement(
                array: [null, $this->faker->url()]
            ),
            'country' => $this->faker->country(),
            'state' => $this->faker->randomElement(
                array: [null, $state]
            ),
            'city' => $this->faker->randomElement(
                array: [null, $this->faker->city()]
            ),
            'zip' => $this->faker->randomElement(
                array: [null, $this->faker->postcode()]
            ),
            'address' => $address,
            'address_2' => $address ? $this->faker->randomElement(
                array: [null, $this->faker->streetAddress()]
            ) : null,
            'phone' => $this->faker->randomElement(
                array: [null, $this->faker->phoneNumber()]
            ),
            'theme' => $this->faker->randomElement(
                array: [null, $this->faker->randomElement(
                    array: ['light', 'dark']
                )]
            ),
            'language' => $this->faker->randomElement(
                array: [null, $this->faker->languageCode()]
            ),
            'email' => $this->faker->unique(
                reset: false,
                maxRetries: 10000
            )->safeEmail(),
            'password' => Hash::make(
                value: $this->faker->word(),
                options: [
                    //
                ]
            ),
            'remember_token' => $this->faker->randomElement(
                array: [null, $this->faker->md5()]
            ),
            'created_at' => $created_date,
            'updated_at' => $updated_date,
            'email_verified_at' => $this->faker->randomElement(
                array: [null, $this->faker->dateTimeBetween(
                    startDate: $created_date,
                    endDate: $updated_date,
                    timezone: env(
                        key: 'APP_TIMEZONE',
                        default: 'UTC'
                    )
                )]
            ),
        ];
    }

    public function unverified(): Factory
    {
        return $this->state(
            state: function (array $attributes) {
                return [
                    'email_verified_at' => null,
                ];
            }
        );
    }
}
