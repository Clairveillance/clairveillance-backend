<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Establishment\EstablishmentType;
use App\Models\Establishment\EstablishmentHasProfile;

final class EstablishmentHasProfileSeeder extends Seeder
{
    public function __construct(
        public LikeSeeder $likeSeeder,
        public ImageSeeder $imageSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new EstablishmentType)->run();
    }

    public function run(): void
    {
        try {
            EstablishmentHasProfile::factory(25)->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (EstablishmentHasProfile $establishment) {
                        $establishment_types = EstablishmentType::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $establishment->created_at
                        )->get();
                        $users = User::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $establishment->created_at
                        )->get();
                        $establishment
                            ->user()->associate($users->random())
                            ->type()->associate($establishment_types->random())
                            ->save();
                        $this->imageSeeder
                            ->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                        $this->postSeeder
                            ->setUsers($users)
                            ->setModel($establishment->profile)
                            ->run();
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }
}
