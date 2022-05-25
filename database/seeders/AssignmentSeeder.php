<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment\AssignmentType;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\User\User;
use Database\Seeders\Concerns\LikeSeederService;
use Illuminate\Database\Seeder;

final class AssignmentSeeder extends Seeder
{
    public function __construct(public LikeSeederService $LikeSeederService)
    {
    }

    public function run(): void
    {
        AssignmentWithProfile::factory(200)->make()
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
                    $this->LikeSeederService->setUsers($users);
                    $this->LikeSeederService->setModel($assignment->profile);
                    $this->LikeSeederService->save();
                    for ($i = 0; $i < rand(1, 10); $i++) {
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

        dump(__METHOD__ . ' [success]');
    }
}
