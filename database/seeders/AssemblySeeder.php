<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Assembly\AssemblyWithProfile;

final class AssemblySeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public ImageSeeder $imageSeeder,
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
                        $this->imageSeeder->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $randomAssemblies = rand(1, 3);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblyAssemblies($assembly),
                            2 => $this->assemblyWithProfileAssemblies($assembly),
                            3 => $this->userAssemblies($assembly),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblyAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
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
        for ($i = 0; $i < rand(1, 25); $i++) {
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

    private function userAssemblies(Assembly $assembly): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
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
