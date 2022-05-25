<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use App\Models\Establishment\EstablishmentType;
use App\Models\Establishment\EstablishmentWithProfile;

final class EstablishmentSeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new EstablishmentType)->run();
    }

    public function run(): void
    {
        try {
            EstablishmentWithProfile::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (EstablishmentWithProfile $establishment) {
                        $establishment_types = EstablishmentType::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->establishment_type_uuid = $establishment_types->random()->uuid;
                        $users = User::where('created_at', '<=', $establishment->created_at)->get();
                        $establishment->user()->associate($users->random())->save();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        for ($i = 0; $i < rand(1, 5); $i++) {
                            try {
                                $establishments = EstablishmentWithProfile::where('uuid', '!=', $establishment->uuid)->get();
                                if ($establishments->isNotEmpty()) {
                                    $establishable = $establishments->random();
                                    if (
                                        $establishable->establishmentEstablishmentsWithProfile->isEmpty()
                                        ||
                                        !$establishable->establishmentEstablishmentsWithProfile->contains($establishment)
                                    ) {
                                        $establishable->establishmentEstablishmentsWithProfile()->attach($establishment);
                                    }
                                }
                                $users = User::all();
                                $establishable = $users->random();
                                if (
                                    $establishable->userEstablishmentsWithProfile->isEmpty()
                                    ||
                                    !$establishable->userEstablishmentsWithProfile->contains($establishment)
                                ) {
                                    $establishable->userEstablishmentsWithProfile()->attach($establishment);
                                }
                                $establishable->save();
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
