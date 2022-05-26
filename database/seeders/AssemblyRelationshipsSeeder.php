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

final class AssemblyRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $assemblies = Assembly::all();
            foreach ($assemblies as $assembly) {
                $randomAssemblies = rand(1, 4);
                match ((int) $randomAssemblies) {
                    1 => $this->assignmentAssemblies($assembly),
                    2 => $this->assignmentWithProfileAssemblies($assembly),
                    3 => $this->establishmentAssemblies($assembly),
                    4 => $this->establishmentWithProfileAssemblies($assembly),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assignmentAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assignments = Assignment::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentAssemblies->isEmpty()
                    ||
                    !$assemblable->assignmentAssemblies->contains($assembly)
                ) {
                    $assemblable->assignmentAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assignments = AssignmentWithProfile::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentWithProfileAssemblies->isEmpty()
                    ||
                    !$assemblable->assignmentWithProfileAssemblies->contains($assembly)
                ) {
                    $assemblable->assignmentWithProfileAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $establishments = Establishment::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentAssemblies->isEmpty()
                    ||
                    !$assemblable->establishmentAssemblies->contains($assembly)
                ) {
                    $assemblable->establishmentAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentWithProfileAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $establishments = EstablishmentWithProfile::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentWithProfileAssemblies->isEmpty()
                    ||
                    !$assemblable->establishmentWithProfileAssemblies->contains($assembly)
                ) {
                    $assemblable->establishmentWithProfileAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
