<?php

declare(strict_types=1);

namespace Database\Seeders;

use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Database\Seeder;
use Infrastructure\Eloquent\Models\Appointment\Appointment;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\ImageSeeder;
use Infrastructure\Eloquent\Models\Appointment\AppointmentType;

final class AppointmentSeeder extends Seeder
{
    public const NUMBER = 50;

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
        $errors = [];
        try {
            Appointment::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: fn ($sort) => $sort->created_at,
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
}
