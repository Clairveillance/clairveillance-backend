<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\AssemblyType;
use Database\Seeders\Shared\LikeSeeder;
use App\Models\Assembly\AssemblyWithProfile;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\PostSeeder;

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
            AssemblyWithProfile::factory(rand(20, 100))->make()
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
                        for ($i = 0; $i < rand(1, 10); $i++) {
                            try {
                                $assemblies = AssemblyWithProfile::where('uuid', '!=', $assembly->uuid)->get();
                                if ($assemblies->isNotEmpty()) {
                                    $assemblable = $assemblies->random();
                                    if (
                                        $assemblable->assemblyAssembliesWithProfile->isEmpty()
                                        ||
                                        !$assemblable->assemblyAssembliesWithProfile->contains($assembly)
                                    ) {
                                        $assemblable->assemblyAssembliesWithProfile()->attach($assembly);
                                    }
                                }
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
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }
}
