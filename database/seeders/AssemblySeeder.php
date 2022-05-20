<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use App\Models\Assignment\Assignment;
use App\Models\Establishment\Establishment;
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
                    $assignments = Assignment::all();
                    $establishments = Establishment::all();
                    $random = rand(1, 5);
                    if (($random === 1)) {
                        $assembly->assignments()->attach($assignments->random());
                    }
                    if (($random === 2)) {
                        $assembly->establishments()->attach($establishments->random());
                    }
                    if (($random === 3)) {
                        $assembly->assignments()->attach($assignments->random());
                        $assembly->establishments()->attach($establishments->random());
                    }
                    $assembly->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
