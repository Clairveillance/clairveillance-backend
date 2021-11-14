<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
