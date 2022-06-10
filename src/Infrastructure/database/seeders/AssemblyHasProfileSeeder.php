<?php

declare(strict_types=1);

namespace Database\Seeders;

use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Infrastructure\Eloquent\Models\Assembly\AssemblyType;
use Infrastructure\Eloquent\Models\User\User;
use Database\Seeders\Shared\ImageSeeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class AssemblyHasProfileSeeder extends Seeder
{
    public const NUMBER = 25;

    public function __construct(
        public LikeSeeder $likeSeeder,
        public ImageSeeder $imageSeeder,
        public PostSeeder $postSeeder,
        public TypeSeeder $typeSeeder
    ) {
        $this->typeSeeder->setModel(new AssemblyType)->run();
    }

    public function run(): void
    {
        $errors = [];
        try {
            AssemblyHasProfile::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: fn ($sort) => $sort->created_at,
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (AssemblyHasProfile $assembly) {
                        $assembly_types = AssemblyType::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $assembly->created_at
                        )->get();
                        $users = User::where(
                            column: 'created_at',
                            operator: '<=',
                            value: $assembly->created_at
                        )->get();
                        $assembly
                            ->user()->associate($users->random())
                            ->type()->associate($assembly_types->random())
                            ->save();
                        $this->imageSeeder
                            ->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $this->postSeeder
                            ->setUsers($users)
                            ->setModel($assembly->profile)
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
