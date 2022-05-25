<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\EstablishmentSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE: Used to disable foreign key constraints while using php artisan db:seed command.
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
                    AssemblySeeder::class,
                    AssignmentSeeder::class,
                    EstablishmentSeeder::class,
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
