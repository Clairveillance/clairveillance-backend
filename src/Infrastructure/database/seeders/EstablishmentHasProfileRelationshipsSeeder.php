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
                dump(__METHOD__ . ' [warning]');
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
                    dump(__METHOD__ . ' [warning]');
                }
            }
        }
    }
}
