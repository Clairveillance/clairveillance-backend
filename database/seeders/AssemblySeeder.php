<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use App\Models\User\User;
use Illuminate\Database\Seeder;

final class AssemblySeeder extends Seeder
{
    public function run(): void
    {
        Assembly::factory(100)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($assembly) {
                    $assembly_types = AssemblyType::where('created_at', '<=', $assembly->created_at)->get();
                    $assembly->assembly_type_uuid = $assembly_types->random()->uuid;
                    $users = User::where('created_at', '<=', $assembly->created_at)->get();
                    $assembly->user()->associate($users->random());
                    $assembly->save();
                    $assemblies = Assembly::all();
                    for ($i = 0; $i < rand(1, 10); $i++) {
                        $assemblable = $assemblies->random();
                        if (
                            $assemblable !== $assembly &&
                            $assemblable !== $assembly->assemblyAssemblables
                        ) {
                            $assembly->assemblyAssemblables()->attach($assemblable);
                        }
                    }
                    $assembly->save();
                    $users = User::all();
                    for ($i = 0; $i < rand(1, 10); $i++) {
                        $assemblable = $users->random();
                        if (
                            $assemblable !== $assembly->userAssemblables
                        ) {
                            $assembly->userAssemblables()->attach($assemblable);
                        }
                    }
                    $assembly->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
