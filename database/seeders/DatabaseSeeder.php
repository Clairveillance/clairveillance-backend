<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        match (config(
            key: 'app.env',
            default: null
        )) {
            'local' => $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                    // PostSeeder::class,
                    EstablishmentTypeSeeder::class,
                    AssignmentTypeSeeder::class,
                    AssemblyTypeSeeder::class,
                    EstablishmentSeeder::class,
                    AssignmentSeeder::class,
                    AssemblySeeder::class,
                ],
                silent: false,
                parameters: [
                    //
                ]
            ),
            'production' => $this->call(
                class: [
                    //
                ],
                silent: false,
                parameters: [
                    //
                ]
            )
        };

        $this->call(
            class: [],
        );
    }
}
