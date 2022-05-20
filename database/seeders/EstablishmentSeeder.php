<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentType;
use App\Models\User\User;
use Illuminate\Database\Seeder;

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
                    $users = User::where('created_at', '<=', $establishment->created_at)->get();
                    $establishment->user()->associate($users->random());
                    $establishment->save();
                }
            );

        dump(__METHOD__ . ' [success]');
    }
}
