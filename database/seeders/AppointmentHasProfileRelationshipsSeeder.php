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

final class AppointmentHasProfileRelationshipsSeeder extends Seeder
{
    public function run(): void
    {
        $errors = [];
        try {
            $appointments = AppointmentHasProfile::has('profile')->get(); // FIXME
            foreach ($appointments as $appointment) {
                $randomAppointments = rand(1, 9);
                match ((int) $randomAppointments) {
                    1 => $this->appointables($appointment, new Appointment),
                    2 => $this->appointables($appointment, new AppointmentHasProfile),
                    3 => $this->appointables($appointment, new Assembly),
                    4 => $this->appointables($appointment, new AssemblyHasProfile),
                    5 => $this->appointables($appointment, new Assignment),
                    6 => $this->appointables($appointment, new AssignmentHasProfile),
                    7 => $this->appointables($appointment, new Establishment),
                    8 => $this->appointables($appointment, new EstablishmentHasProfile),
                    9 => $this->appointables($appointment, new User),
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

    private function appointables(AppointmentHasProfile $appointment, Model $model): void
    {
        $errors = [];
        $pivots = ['has_profile' => 1];
        for ($i = 0; $i < 5; $i++) {
            try {
                $models = $model::where('uuid', '!=', $appointment->uuid)->get();
                if ($models->isNotEmpty()) {
                    $appointable = $models->random();
                    if (
                        $appointment->appointables($model)->get()->isEmpty()
                        ||
                        ! $appointment->appointables($model)->get()->contains($appointable)
                    ) {
                        $appointment->appointables($model)->attach($appointable, $pivots);
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
