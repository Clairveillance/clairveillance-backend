<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use App\Models\Appointment\Appointment;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Appointment\AppointmentType;

final class AppointmentSeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public ImageSeeder $imageSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new AppointmentType)->run();
    }

    public function run(): void
    {
        try {
            Appointment::factory(50)->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Appointment $appointment) {
                        $appointment_types = AppointmentType::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $appointment->created_at
                        )->get();
                        $users = User::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $appointment->created_at
                        )->get();
                        $appointment
                            ->user()->associate($users->random())
                            ->type()->associate($appointment_types->random())
                            ->save();
                        $this->imageSeeder
                            ->setUsers($users)
                            ->setModel($appointment)
                            ->run();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($appointment)
                            ->run();
                        $this->postSeeder
                            ->setUsers($users)
                            ->setModel($appointment)
                            ->run();
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }
}