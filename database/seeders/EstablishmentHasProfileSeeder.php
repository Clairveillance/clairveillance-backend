<?php

declare(strict_types=1);

namespace Database\Seeders;

use Infrastructure\Models\Establishment\EstablishmentHasProfile;
use Infrastructure\Models\Establishment\EstablishmentType;
use Infrastructure\Models\User\User;
use Database\Seeders\Shared\ImageSeeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class EstablishmentHasProfileSeeder extends Seeder
{
    public const NUMBER = 25;

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
        $errors = [];
        try {
            EstablishmentHasProfile::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: fn ($sort) => $sort->created_at,
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
            if (empty($errors)) {
                $errors[] = true;
                dump(__METHOD__ . ' [warning]');
            }
        }
        if (empty($errors)) {
            $errors[] = false;
            dump(__METHOD__ . ' [success]');
        }
    }
}
