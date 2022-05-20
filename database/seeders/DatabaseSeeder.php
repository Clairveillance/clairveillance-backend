<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        dump('Environment => '.config('app.env')."\n".'Database Statement => SET FOREIGN_KEY_CHECKS=0');

        match (config(
            key: 'app.env',
            default: null
        )) {
            'local' => $this->call(
                class: [
                    DefaultUserSeeder::class,
                    UserSeeder::class,
                    PostTypeSeeder::class,
                    EstablishmentTypeSeeder::class,
                    AssignmentTypeSeeder::class,
                    AssemblyTypeSeeder::class,
                    PostSeeder::class,
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

        dump(__METHOD__.' [success]');
    }
}
