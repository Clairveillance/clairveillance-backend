<?php

declare(strict_types=1);

namespace Database\Seeders;

use Infrastructure\Eloquent\Models\Appointment\Appointment;
use Infrastructure\Eloquent\Models\Appointment\AppointmentHasProfile;
use Infrastructure\Eloquent\Models\Assembly\Assembly;
use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Infrastructure\Eloquent\Models\Assignment\Assignment;
use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;
use Infrastructure\Eloquent\Models\Establishment\Establishment;
use Infrastructure\Eloquent\Models\Establishment\EstablishmentHasProfile;
use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

final class AssignmentHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        $errors = [];
        try {
            $assignments = AssignmentHasProfile::has('profile')->get(); // FIXME
            foreach ($assignments as $assignment) {
                $randomAssignments = rand(1, 9);
                match ((int) $randomAssignments) {
                    1 => $this->assignables($assignment, new Appointment),
                    2 => $this->assignables($assignment, new AppointmentHasProfile),
                    3 => $this->assignables($assignment, new Assembly),
                    4 => $this->assignables($assignment, new AssemblyHasProfile),
                    5 => $this->assignables($assignment, new Assignment),
                    6 => $this->assignables($assignment, new AssignmentHasProfile),
                    7 => $this->assignables($assignment, new Establishment),
                    8 => $this->assignables($assignment, new EstablishmentHasProfile),
                    9 => $this->assignables($assignment, new User),
                };
            }
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

    private function assignables(AssignmentHasProfile $assignment, Model $model): void
    {
        $errors = [];
        $pivots = ['has_profile' => 1];
        for ($i = 0; $i < 5; $i++) {
            try {
                $models = $model::where('uuid', '!=', $assignment->uuid)->get();
                if ($models->isNotEmpty()) {
                    $assignable = $models->random();
                    if (
                        $assignment->assignables($model)->get()->isEmpty()
                        ||
                        !$assignment->assignables($model)->get()->contains($assignable)
                    ) {
                        $assignment->assignables($model)->attach($assignable, $pivots);
                    }
                }
            } catch (\Throwable $e) {
                if (empty($errors)) {
                    $errors[] = true;
                    dump(__METHOD__ . ' [warning]');
                }
            }
        }
    }
}
