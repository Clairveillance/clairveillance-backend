<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use App\Models\Assignment\Assignment;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentWithProfile;

final class AssemblySeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new AssemblyType)->run();
    }

    public function run(): void
    {
        try {
            Assembly::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Assembly $assembly) {
                        $assembly_types = AssemblyType::where('created_at', '<=', $assembly->created_at)->get();
                        $assembly->assembly_type_uuid = $assembly_types->random()->uuid;
                        $users = User::where('created_at', '<=', $assembly->created_at)->get();
                        $assembly->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $randomAssemblies = rand(1, 7);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblyAssemblies($assembly),
                            2 => $this->assemblyWithProfileAssemblies($assembly),
                            3 => $this->assignmentAssemblies($assembly),
                            4 => $this->assignmentWithProfileAssemblies($assembly),
                            5 => $this->assignmentWithProfileAssemblies($assembly),
                            6 => $this->establishmentWithProfileAssemblies($assembly),
                            7 => $this->userAssemblies($assembly),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblyAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $assemblies = Assembly::where('uuid', '!=', $assembly->uuid)->get();
                if ($assemblies->isNotEmpty()) {
                    $assemblable = $assemblies->random();
                    if (
                        $assemblable->assemblyAssemblies->isEmpty()
                        ||
                        !$assemblable->assemblyAssemblies->contains($assembly)
                    ) {
                        $assemblable->assemblyAssemblies()->attach($assembly);
                    }
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assemblyWithProfileAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $assemblies = AssemblyWithProfile::where('uuid', '!=', $assembly->uuid)->get();
                if ($assemblies->isNotEmpty()) {
                    $assemblable = $assemblies->random();
                    if (
                        $assemblable->assemblyWithProfileAssemblies->isEmpty()
                        ||
                        !$assemblable->assemblyWithProfileAssemblies->contains($assembly)
                    ) {
                        $assemblable->assemblyWithProfileAssemblies()->attach($assembly);
                    }
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $assignments = Assignment::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentAssemblies->isEmpty()
                    ||
                    !$assemblable->assignmentAssemblies->contains($assembly)
                ) {
                    $assemblable->assignmentAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $assignments = AssignmentWithProfile::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentWithProfileAssemblies->isEmpty()
                    ||
                    !$assemblable->assignmentWithProfileAssemblies->contains($assembly)
                ) {
                    $assemblable->assignmentWithProfileAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $establishments = Establishment::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentAssemblies->isEmpty()
                    ||
                    !$assemblable->establishmentAssemblies->contains($assembly)
                ) {
                    $assemblable->establishmentAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentWithProfileAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $establishments = EstablishmentWithProfile::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentWithProfileAssemblies->isEmpty()
                    ||
                    !$assemblable->establishmentWithProfileAssemblies->contains($assembly)
                ) {
                    $assemblable->establishmentWithProfileAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function userAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 140); $i++) {
            try {
                $users = User::all();
                $assemblable = $users->random();
                if (
                    $assemblable->userAssemblies->isEmpty()
                    ||
                    !$assemblable->userAssemblies->contains($assembly)
                ) {
                    $assemblable->userAssemblies()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
