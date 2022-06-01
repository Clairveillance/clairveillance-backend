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

final class EstablishmentHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        $errors = [];
        try {
            $establishments = EstablishmentHasProfile::has('profile')->get(); // FIXME
            foreach ($establishments as $establishment) {
                $randomeEtablishments = rand(1, 9);
                match ((int) $randomeEtablishments) {
                    1 => $this->establishables($establishment, new Appointment),
                    2 => $this->establishables($establishment, new AppointmentHasProfile),
                    3 => $this->establishables($establishment, new Assembly),
                    4 => $this->establishables($establishment, new AssemblyHasProfile),
                    5 => $this->establishables($establishment, new Assignment),
                    6 => $this->establishables($establishment, new AssignmentHasProfile),
                    7 => $this->establishables($establishment, new Establishment),
                    8 => $this->establishables($establishment, new EstablishmentHasProfile),
                    9 => $this->establishables($establishment, new User),
                };
            }
        } catch (\Throwable $e) {
            if (empty($errors)) {
                $errors[] = true;
                dump(__METHOD__ . ' [error]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__ . ' [success]');
        }
    }

    private function establishables(EstablishmentHasProfile $establishment, Model $model): void
    {
        $errors = [];
        $pivots = ['has_profile' => 1];
        for ($i = 0; $i < 5; $i++) {
            try {
                $models = $model::where('uuid', '!=', $establishment->uuid)->get();
                if ($models->isNotEmpty()) {
                    $establishable = $models->random();
                    if (
                        $establishment->establishables($model)->get()->isEmpty()
                        ||
                        !$establishment->establishables($model)->get()->contains($establishable)
                    ) {
                        $establishment->establishables($model)->attach($establishable, $pivots);
                    }
                }
            } catch (\Throwable $e) {
                if (empty($errors)) {
                    $errors[] = true;
                    dump(__METHOD__ . ' [error]');
                }
            }
        }
    }
}
