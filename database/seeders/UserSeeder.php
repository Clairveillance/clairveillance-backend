<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(499)->make()
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
                    // $users = User::all();
                    // for ($i = 0; $i < rand(1, 10); $i++) {
                    //     $assemblable = $users->random();
                    //     if (
                    //         $assemblable !== $user &&
                    //         $assemblable !== $user->assemblableUsers
                    //     ) {
                    //         $user->assemblableUsers()->attach($assemblable);
                    //     }
                    // }
                    // $user->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
