<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentWithProfile;

final class AssemblyWithProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $assemblies = AssemblyWithProfile::all();
            foreach ($assemblies as $assembly) {
                $randomAssemblies = rand(1, 4);
                match ((int) $randomAssemblies) {
                    1 => $this->assignmentAssembliesWithProfile($assembly),
                    2 => $this->assignmentWithProfileAssembliesWithProfile($assembly),
                    3 => $this->establishmentAssembliesWithProfile($assembly),
                    4 => $this->establishmentWithProfileAssembliesWithProfile($assembly),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assignmentAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assignments = Assignment::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->assignmentAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->assignmentAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assignments = AssignmentWithProfile::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentWithProfileAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->assignmentWithProfileAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->assignmentWithProfileAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $establishments = Establishment::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->establishmentAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->establishmentAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentWithProfileAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $establishments = EstablishmentWithProfile::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentWithProfileAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->establishmentWithProfileAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->establishmentWithProfileAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
