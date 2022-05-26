<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentType;
use App\Models\Establishment\EstablishmentWithProfile;
use App\Models\User\User;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class EstablishmentWithProfileSeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new EstablishmentType)->run();
    }

    public function run(): void
    {
        try {
            EstablishmentWithProfile::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (EstablishmentWithProfile $establishment) {
                        $establishment_types = EstablishmentType::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->establishment_type_uuid = $establishment_types->random()->uuid;
                        $users = User::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        $randomAssemblies = rand(1, 3);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblyWithProfileEstablishmentsWithProfile($establishment),
                            2 => $this->assignmentWithProfileEstablishmentsWithProfile($establishment),
                            3 => $this->userEstablishmentsWithProfile($establishment),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__.' [success]');
    }

    private function assemblyWithProfileEstablishmentsWithProfile(EstablishmentWithProfile $establishment): void
    {
        for ($i = 0; $i < rand(1, 50); $i++) {
            try {
                $assemblies = AssemblyWithProfile::all();
                $establishable = $assemblies->random();
                if (
                    $establishable->assemblyWithProfileEstablishmentsWithProfile->isEmpty()
                    ||
                    ! $establishable->assemblyWithProfileEstablishmentsWithProfile->contains($establishment)
                ) {
                    $establishable->assemblyWithProfileEstablishmentsWithProfile()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileEstablishmentsWithProfile(EstablishmentWithProfile $establishment): void
    {
        for ($i = 0; $i < rand(1, 50); $i++) {
            try {
                $assigments = AssignmentWithProfile::all();
                $establishable = $assigments->random();
                if (
                    $establishable->assignmentWithProfileEstablishmentsWithProfile->isEmpty()
                    ||
                    ! $establishable->assignmentWithProfileEstablishmentsWithProfile->contains($establishment)
                ) {
                    $establishable->assignmentWithProfileEstablishmentsWithProfile()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function userEstablishmentsWithProfile(EstablishmentWithProfile $establishment): void
    {
        for ($i = 0; $i < rand(5, 25); $i++) {
            try {
                $users = User::all();
                $establishable = $users->random();
                if (
                    $establishable->userEstablishmentsWithProfile->isEmpty()
                    ||
                    ! $establishable->userEstablishmentsWithProfile->contains($establishment)
                ) {
                    $establishable->userEstablishmentsWithProfile()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
