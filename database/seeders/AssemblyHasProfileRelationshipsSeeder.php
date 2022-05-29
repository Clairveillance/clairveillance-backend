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
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentWithProfile;

final class AssemblyHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $assemblies = AssemblyHasProfile::has('profile')->get(); // FIXME
            foreach ($assemblies as $assembly) {
                $randomAssemblies = rand(1, 7);
                match ((int) $randomAssemblies) {
                    1 => $this->assemblables($assembly, new Assembly),
                    2 => $this->assemblables($assembly, new AssemblyHasProfile),
                    3 => $this->assemblables($assembly, new Assignment),
                    4 => $this->assemblables($assembly, new AssignmentWithProfile),
                    5 => $this->assemblables($assembly, new Establishment),
                    6 => $this->assemblables($assembly, new EstablishmentWithProfile),
                    7 => $this->assemblables($assembly, new User),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblables(AssemblyHasProfile $assembly, Model $model): void
    {
        $pivots = ['has_profile' => 1];
        for ($i = 0; $i < rand(1, 125); $i++) {
            try {
                $models = $model::where('uuid', '!=', $assembly->uuid)->get();
                if ($models->isNotEmpty()) {
                    $assemblable = $models->random();
                    if (
                        $assembly->assemblables($model)->get()->isEmpty()
                        ||
                        !$assembly->assemblables($model)->get()->contains($assemblable)
                    ) {
                        $assembly->assemblables($model)->attach($assemblable, $pivots);
                    }
                }
            } catch (\Throwable  $e) {
            }
        }
    }
}
