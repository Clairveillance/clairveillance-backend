<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;

final class AssignmentHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $assignments = AssignmentHasProfile::has('profile')->get(); // FIXME
            foreach ($assignments as $assignment) {
                $randomAssignments = rand(1, 7);
                match ((int) $randomAssignments) {
                    1 => $this->assignables($assignment, new Assembly),
                    2 => $this->assignables($assignment, new AssemblyHasProfile),
                    3 => $this->assignables($assignment, new Assignment),
                    4 => $this->assignables($assignment, new AssignmentHasProfile),
                    5 => $this->assignables($assignment, new Establishment),
                    6 => $this->assignables($assignment, new EstablishmentHasProfile),
                    7 => $this->assignables($assignment, new User),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assignables(AssignmentHasProfile $assignment, Model $model): void
    {
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
            } catch (\Throwable  $e) {
            }
        }
    }
}
