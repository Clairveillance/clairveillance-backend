<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PostTypeSeeder;
use Database\Seeders\DefaultUserSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // dump('Environment => ' . config('app.env') . "\n" . 'Database Statement => SET FOREIGN_KEY_CHECKS=0');

        match (config(
            key: 'app.env',
            default: null
        )) {
            'local' => $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                    PostTypeSeeder::class,
                    PostSeeder::class,
                    AssemblyTypeSeeder::class,
                    AssemblySeeder::class,
                    AssignmentTypeSeeder::class,
                    AssignmentSeeder::class,
                    // EstablishmentTypeSeeder::class,
                    // EstablishmentSeeder::class,
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

        dump(__METHOD__ . ' [success]');
    }
}
