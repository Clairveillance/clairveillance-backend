<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DefaultUserSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        match (config('app.env')) {
            'local' => $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                    PostSeeder::class,
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
