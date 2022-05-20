<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User\User;
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

        return [
            'username' => $this->faker->unique(
                reset: false,
                maxRetries: 10000
            )->userName(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'description' => $this->faker->randomElement(
                array: [null, $this->faker->sentence(
                    nbWords: random_int(
                        min: 1,
                        max: 25
                    ),
                    variableNbWords: true
                )]
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
