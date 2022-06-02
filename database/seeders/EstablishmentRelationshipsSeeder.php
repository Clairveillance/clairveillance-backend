<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Appointment\Appointment;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentHasProfile;
use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentHasProfile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

final class EstablishmentRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        $errors = [];
        try {
            $establishments = Establishment::has('likes')->get(); // FIXME
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
                dump(__METHOD__.' [error]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__.' [success]');
        }
    }

    private function establishables(Establishment $establishment, Model $model): void
    {
        $errors = [];
        $pivots = ['has_profile' => 0];
        for ($i = 0; $i < 10; $i++) {
            try {
                $models = $model::where('uuid', '!=', $establishment->uuid)->get();
                if ($models->isNotEmpty()) {
                    $establishable = $models->random();
                    if (
                        $establishment->establishables($model)->get()->isEmpty()
                        ||
                        ! $establishment->establishables($model)->get()->contains($establishable)
                    ) {
                        $establishment->establishables($model)->attach($establishable, $pivots);
                    }
                }
            } catch (\Throwable $e) {
                if (empty($errors)) {
                    $errors[] = true;
                    dump(__METHOD__.' [error]');
                }
            }
        }
    }
}
