<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Assembly;
use App\Models\AssemblyType;
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
                    $assembly->save();
                    $users = User::where('created_at', '<=', $assembly->created_at)->get();
                    $assembly->users()->save($users->random());
                }
            );
    }
}
