<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AssignmentType;
use Illuminate\Database\Seeder;

final class AssignmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        AssignmentType::factory(25)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($assignment_type) {
                    $assignment_type->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
