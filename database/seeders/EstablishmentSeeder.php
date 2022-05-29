<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Establishment\EstablishmentType;
use App\Models\Assignment\AssignmentWithProfile;

final class EstablishmentSeeder extends Seeder
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
            Establishment::factory(rand(25, 50))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Establishment $establishment) {
                        $establishment_types = EstablishmentType::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->establishment_type_uuid = $establishment_types->random()->uuid;
                        $users = User::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($establishment)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($establishment)
                            ->run();
                        $randomAssemblies = rand(1, 5);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblyEstablishments($establishment),
                            2 => $this->assemblyWithProfileEstablishments($establishment),
                            3 => $this->assignmentEstablishments($establishment),
                            4 => $this->assignmentWithProfileEstablishments($establishment),
                            5 => $this->userEstablishments($establishment),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblyEstablishments(Establishment $establishment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assemblies = Assembly::all();
                $establishable = $assemblies->random();
                if (
                    $establishable->assemblyEstablishments->isEmpty()
                    ||
                    !$establishable->assemblyEstablishments->contains($establishment)
                ) {
                    $establishable->assemblyEstablishments()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assemblyWithProfileEstablishments(Establishment $establishment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assemblies = AssemblyHasProfile::all();
                $establishable = $assemblies->random();
                if (
                    $establishable->assemblyWithProfileEstablishments->isEmpty()
                    ||
                    !$establishable->assemblyWithProfileEstablishments->contains($establishment)
                ) {
                    $establishable->assemblyWithProfileEstablishments()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentEstablishments(Establishment $establishment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assigments = Assignment::all();
                $establishable = $assigments->random();
                if (
                    $establishable->assignmentEstablishments->isEmpty()
                    ||
                    !$establishable->assignmentEstablishments->contains($establishment)
                ) {
                    $establishable->assignmentEstablishments()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileEstablishments(Establishment $establishment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $assigments = AssignmentWithProfile::all();
                $establishable = $assigments->random();
                if (
                    $establishable->assignmentWithProfileEstablishments->isEmpty()
                    ||
                    !$establishable->assignmentWithProfileEstablishments->contains($establishment)
                ) {
                    $establishable->assignmentWithProfileEstablishments()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function userEstablishments(Establishment $establishment): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $users = User::all();
                $establishable = $users->random();
                if (
                    $establishable->userEstablishments->isEmpty()
                    ||
                    !$establishable->userEstablishments->contains($establishment)
                ) {
                    $establishable->userEstablishments()->attach($establishment);
                }
                $establishable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
