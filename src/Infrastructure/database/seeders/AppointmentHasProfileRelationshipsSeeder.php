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
                dump(__METHOD__ . ' [warning]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__ . ' [success]');
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
                        !$appointment->appointables($model)->get()->contains($appointable)
                    ) {
                        $appointment->appointables($model)->attach($appointable, $pivots);
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
