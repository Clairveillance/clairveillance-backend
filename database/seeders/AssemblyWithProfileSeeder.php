<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\AssemblyType;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\EstablishmentWithProfile;
use App\Models\User\User;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class AssemblyWithProfileSeeder extends Seeder
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
            AssemblyWithProfile::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (AssemblyWithProfile $assembly) {
                        $assembly_types = AssemblyType::where('created_at', '<=', $assembly->created_at)->get();
                        $assembly->assembly_type_uuid = $assembly_types->random()->uuid;
                        $users = User::where('created_at', '<=', $assembly->created_at)->get();
                        $assembly->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $randomAssemblies = rand(1, 4);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblyWithProfileAssembliesWithProfile($assembly),
                            2 => $this->assignmentWithProfileAssembliesWithProfile($assembly),
                            3 => $this->establishmentWithProfileAssembliesWithProfile($assembly),
                            4 => $this->userAssembliesWithProfile($assembly),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblyWithProfileAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 120); $i++) {
            try {
                $assemblies = AssemblyWithProfile::where('uuid', '!=', $assembly->uuid)->get();
                if ($assemblies->isNotEmpty()) {
                    $assemblable = $assemblies->random();
                    if (
                        $assemblable->assemblyWithProfileAssembliesWithProfile->isEmpty()
                        ||
                        !$assemblable->assemblyWithProfileAssembliesWithProfile->contains($assembly)
                    ) {
                        $assemblable->assemblyWithProfileAssembliesWithProfile()->attach($assembly);
                    }
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function assignmentWithProfileAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 120); $i++) {
            try {
                $assignments = AssignmentWithProfile::all();
                $assemblable = $assignments->random();
                if (
                    $assemblable->assignmentWithProfileAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->assignmentWithProfileAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->assignmentWithProfileAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function establishmentWithProfileAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 120); $i++) {
            try {
                $establishments = EstablishmentWithProfile::all();
                $assemblable = $establishments->random();
                if (
                    $assemblable->establishmentWithProfileAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->establishmentWithProfileAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->establishmentWithProfileAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }

    private function userAssembliesWithProfile(AssemblyWithProfile $assembly): void
    {
        for ($i = 0; $i < rand(1, 120); $i++) {
            try {
                $users = User::all();
                $assemblable = $users->random();
                if (
                    $assemblable->userAssembliesWithProfile->isEmpty()
                    ||
                    !$assemblable->userAssembliesWithProfile->contains($assembly)
                ) {
                    $assemblable->userAssembliesWithProfile()->attach($assembly);
                }
                $assemblable->save();
            } catch (\Throwable  $e) {
            }
        }
    }
}
