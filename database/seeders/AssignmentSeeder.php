<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentType;
use App\Models\User\User;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class AssignmentSeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new AssignmentType)->run();
    }

    public function run(): void
    {
        try {
            Assignment::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Assignment $assignment) {
                        $assignment_types = AssignmentType::where('created_at', '<=', $assignment->created_at)->get();
                        $assignment->assignment_type_uuid = $assignment_types->random()->uuid;
                        $users = User::where('created_at', '<=', $assignment->created_at)->get();
                        $assignment->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assignment)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assignment)
                            ->run();
                        $this->userAssignments($assignment);
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__.' [success]');
    }

    private function userAssignments(Assignment $assignment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $users = User::all();
                $assignable = $users->random();
                if (
                    $assignable->userAssignments->isEmpty()
                    ||
                    ! $assignable->userAssignments->contains($assignment)
                ) {
                    $assignable->userAssignments()->attach($assignment);
                }
                $assignable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
