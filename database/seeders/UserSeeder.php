<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;

final class UserSeeder extends Seeder
{
    public const NUMBER = 199;

    public function __construct(
        public LikeSeeder $likeSeeder
    ) {
    }

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
                        $users = User::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $user->created_at
                        )->get();
                        $user->save();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($user->profile)
                            ->run();
                    }
                );
        } catch (\Throwable $e) {
            if (empty($errors)) {
                $errors[] = true;
                dump(__METHOD__ . ' [warning]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__ . ' [success]');
        }
    }
}
