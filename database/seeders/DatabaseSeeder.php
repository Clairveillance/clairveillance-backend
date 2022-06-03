<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AssemblySeeder;
use Database\Seeders\AssignmentSeeder;
use Database\Seeders\AppointmentSeeder;
use Database\Seeders\DefaultUserSeeder;
use Illuminate\Database\Capsule\Manager;
use Database\Seeders\EstablishmentSeeder;
use Database\Seeders\AssemblyHasProfileSeeder;
use Database\Seeders\AssignmentHasProfileSeeder;
use Database\Seeders\AppointmentHasProfileSeeder;
use Database\Seeders\AssemblyRelationshipsSeeder;
use Database\Seeders\AssignmentRelationshipsSeeder;
use Database\Seeders\EstablishmentHasProfileSeeder;
use Database\Seeders\AppointmentRelationshipsSeeder;
use Database\Seeders\EstablishmentRelationshipsSeeder;
use Database\Seeders\AssemblyHasProfileRelationshipsSeeder;
use Database\Seeders\AssignmentHasProfileRelationshipsSeeder;
use Database\Seeders\AppointmentHasProfileRelationshipsSeeder;
use Database\Seeders\EstablishmentHasProfileRelationshipsSeeder;

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
                    AssignmentSeeder::class,
                    AppointmentSeeder::class,
                    EstablishmentSeeder::class,
                    AssemblyHasProfileSeeder::class,
                    AssignmentHasProfileSeeder::class,
                    AppointmentHasProfileSeeder::class,
                    EstablishmentHasProfileSeeder::class,
                ],
                silent: false,
                parameters: [
                    //
                ]
            )->call(
                class: [
                    // NOTE: Some relationships must be attached last because they depend on other Models that need to be created first.
                    AssemblyRelationshipsSeeder::class,
                    AssignmentRelationshipsSeeder::class,
                    AppointmentRelationshipsSeeder::class,
                    EstablishmentRelationshipsSeeder::class,
                    AssemblyHasProfileRelationshipsSeeder::class,
                    AssignmentHasProfileRelationshipsSeeder::class,
                    AppointmentHasProfileRelationshipsSeeder::class,
                    EstablishmentHasProfileRelationshipsSeeder::class,
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
