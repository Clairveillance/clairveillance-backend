<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use App\Models\Assignment\AssignmentType;
use App\Models\Assignment\AssignmentWithProfile;

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
            AssignmentWithProfile::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (AssignmentWithProfile $assignment) {
                        $assignment_types = AssignmentType::where('created_at', '<=', $assignment->created_at)->get();
                        $assignment->assignment_type_uuid = $assignment_types->random()->uuid;
                        $users = User::where('created_at', '<=', $assignment->created_at)->get();
                        $assignment->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assignment->profile)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assignment->profile)
                            ->run();
                        for ($i = 0; $i < rand(1, 5); $i++) {
                            try {
                                $assignments = AssignmentWithProfile::where('uuid', '!=', $assignment->uuid)->get();
                                if ($assignments->isNotEmpty()) {
                                    $assignable = $assignments->random();
                                    if (
                                        $assignable->assignmentAssignmentsWithProfile->isEmpty()
                                        ||
                                        !$assignable->assignmentAssignmentsWithProfile->contains($assignment)
                                    ) {
                                        $assignable->assignmentAssignmentsWithProfile()->attach($assignment);
                                    }
                                }
                                $users = User::all();
                                $assignable = $users->random();
                                if (
                                    $assignable->userAssignmentsWithProfile->isEmpty()
                                    ||
                                    !$assignable->userAssignmentsWithProfile->contains($assignment)
                                ) {
                                    $assignable->userAssignmentsWithProfile()->attach($assignment);
                                }
                                $assignable->save();
                            } catch (\Throwable  $e) {
                            }
                        }
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }
}
