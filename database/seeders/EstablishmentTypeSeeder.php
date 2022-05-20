<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\EstablishmentType;
use Illuminate\Database\Seeder;

final class EstablishmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        EstablishmentType::factory(25)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($establishment_type) {
                    $establishment_type->save();
                }
            );

        dump(__METHOD__.' [success]');
    }
}
