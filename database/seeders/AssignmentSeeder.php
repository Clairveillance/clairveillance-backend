<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentType;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Seeder;

final class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        Assignment::factory(100)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($assignment) {
                    $assignment_types = AssignmentType::where('created_at', '<=', $assignment->created_at)->get();
                    $assignment->assignment_type_uuid = $assignment_types->random()->uuid;
                    $assignment->save();
                    $users = User::where('created_at', '<=', $assignment->created_at)->get();
                    $assignment->users()->save($users->random());
                    $establishments = Establishment::all();
                    $random = rand(1, 5);
                    if ($random === 1) {
                        $assignment->establishments()->save($establishments->random());
                    }
                }
            );
    }
}
