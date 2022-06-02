<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Assignment\AssignmentType;
use App\Models\User\User;
use Database\Seeders\Shared\ImageSeeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class AssignmentHasProfileSeeder extends Seeder
{
    public const NUMBER = 25;

    public function __construct(
        public LikeSeeder $likeSeeder,
        public ImageSeeder $imageSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new AssignmentType)->run();
    }

    public function run(): void
    {
        $errors = [];
        try {
            AssignmentHasProfile::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (AssignmentHasProfile $assignment) {
                        $assignment_types = AssignmentType::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $assignment->created_at
                        )->get();
                        $users = User::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $assignment->created_at
                        )->get();
                        $assignment
                            ->user()->associate($users->random())
                            ->type()->associate($assignment_types->random())
                            ->save();
                        $this->imageSeeder
                            ->setUsers($users)
                            ->setModel($assignment->profile)
                            ->run();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($assignment->profile)
                            ->run();
                        $this->postSeeder
                            ->setUsers($users)
                            ->setModel($assignment->profile)
                            ->run();
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
