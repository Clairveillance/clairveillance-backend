<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public const NUMBER = 199;

    public function run(): void
    {
        $errors = [];
        try {
            User::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function ($user) {
                        $user->save();
                    }
                );
        } catch (\Throwable $e) {
            if (empty($errors)) {
                $errors[] = true;
                dump(__METHOD__.' [error]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__.' [success]');
        }
    }
}
