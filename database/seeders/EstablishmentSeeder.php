<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly;
use App\Models\Assignment;
use App\Models\User;
use App\Models\Establishment;
use Illuminate\Database\Seeder;
use App\Models\EstablishmentType;

final class EstablishmentSeeder extends Seeder
{
    public function run(): void
    {
        Establishment::factory(100)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($establishment) {
                    $establishment_types = EstablishmentType::where('created_at', '<=', $establishment->created_at)->get();
                    $establishment->establishment_type_uuid = $establishment_types->random()->uuid;
                    $establishment->save();
                    $users = User::where('created_at', '<=', $establishment->created_at)->get();
                    $establishment->users()->save($users->random());
                }
            );
    }
}
