<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (env('APP_ENV') === 'local') {
            $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class
                ],
            );
        }
        $this->call(
            class: [],
        );
    }
}
