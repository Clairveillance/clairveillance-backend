<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        match (env('APP_ENV')) {
            'local' => $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                ],
            ),
            'production' => $this->call(
                class: [
                    //
                ],
            )
        };

        $this->call(
            class: [],
        );
    }
}
