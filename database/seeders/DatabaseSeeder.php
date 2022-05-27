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
use Database\Seeders\AssemblyRelationshipsSeeder;
use Database\Seeders\AssignmentWithProfileSeeder;
use Database\Seeders\EstablishmentWithProfileSeeder;
use Database\Seeders\AssemblyWithProfileRelationshipsSeeder;

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
                    // IMPORTANT: Don't change the order of Seeders or the system will break.
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                    AssemblySeeder::class,
                    AssemblyWithProfileSeeder::class,
                    AssignmentSeeder::class,
                    AssignmentWithProfileSeeder::class,
                    EstablishmentSeeder::class,
                    EstablishmentWithProfileSeeder::class,
                ],
                silent: false,
                parameters: [
                    //
                ]
            )->call(
                class: [
                    // NOTE: Some relationships must be attached last because they depend on other Models that need to be created first.
                    AssemblyRelationshipsSeeder::class,
                    AssemblyWithProfileRelationshipsSeeder::class,
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
