<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AssemblySeeder;
use Database\Seeders\AssignmentSeeder;
use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\EstablishmentSeeder;
use Database\Seeders\AssemblyWithProfileSeeder;
use Database\Seeders\AssignmentWithProfileSeeder;
use Database\Seeders\EstablishmentWithProfileSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE: Use the following statement to disable foreign key constraints while running seeders.
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
                    AssignmentSeeder::class,
                    AssignmentWithProfileSeeder::class,
                    EstablishmentSeeder::class,
                    AssemblySeeder::class,
                    EstablishmentWithProfileSeeder::class,
                    AssemblyWithProfileSeeder::class,
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
