<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Appointment\Appointment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Establishment\Establishment;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;

final class AssemblyHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $assemblies = AssemblyHasProfile::has('profile')->get(); // FIXME
            foreach ($assemblies as $assembly) {
                $randomAssemblies = rand(1, 9);
                match ((int) $randomAssemblies) {
                    1 => $this->assemblables($assembly, new Appointment),
                    2 => $this->assemblables($assembly, new AppointmentHasProfile),
                    3 => $this->assemblables($assembly, new Assembly),
                    4 => $this->assemblables($assembly, new AssemblyHasProfile),
                    5 => $this->assemblables($assembly, new Assignment),
                    6 => $this->assemblables($assembly, new AssignmentHasProfile),
                    7 => $this->assemblables($assembly, new Establishment),
                    8 => $this->assemblables($assembly, new EstablishmentHasProfile),
                    9 => $this->assemblables($assembly, new User),
                };
            }
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblables(AssemblyHasProfile $assembly, Model $model): void
    {
        $pivots = ['has_profile' => 1];
        for ($i = 0; $i < 5; $i++) {
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
