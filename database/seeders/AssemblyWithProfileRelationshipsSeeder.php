<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment\Assignment;
use Illuminate\Database\Eloquent\Model;
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
                    1 => $this->assemblables($assembly, new Assignment()),
                    2 => $this->assemblables($assembly, new AssignmentWithProfile()),
                    3 => $this->assemblables($assembly, new Establishment()),
                    4 => $this->assemblables($assembly, new EstablishmentWithProfile()),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblables(AssemblyWithProfile $assembly, Model $model): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $models = $model::where('uuid', '!=', $assembly->uuid)->get();
                if ($models->isNotEmpty()) {
                    $assemblable = $models->random();
                    if (
                        $assembly->assemblables($model)->get()->isEmpty()
                        ||
                        !$assembly->assemblables($model)->get()->contains($assemblable)
                    ) {
                        $assembly->assemblables($model)->attach($assemblable);
                    }
                }
            } catch (\Throwable  $e) {
            }
        }
    }
}
