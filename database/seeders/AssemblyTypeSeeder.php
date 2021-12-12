<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AssemblyType;
use Illuminate\Database\Seeder;

final class AssemblyTypeSeeder extends Seeder
{
    public function run(): void
    {
        AssemblyType::factory(25)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($assembly_type) {
                    $assembly_type->save();
                }
            );
    }
}
