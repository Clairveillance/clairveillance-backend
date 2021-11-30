<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domain\User\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(499)->make()
            ->sortBy(function ($sort) {
                return $sort->created_at;
            })
            ->each(
                function ($user) {
                    $user->save();
                }
            );
    }
}
