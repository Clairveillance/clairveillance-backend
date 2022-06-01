<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Assignment\AssignmentType;
use App\Models\Assignment\AssignmentHasProfile;

final class AssignmentHasProfileSeeder extends Seeder
{
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
        try {
            AssignmentHasProfile::factory(25)->make()
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
        }
        dump(__METHOD__ . ' [success]');
    }
}
