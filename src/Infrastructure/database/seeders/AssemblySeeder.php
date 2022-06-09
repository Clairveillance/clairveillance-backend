<?php

declare(strict_types=1);

namespace Database\Seeders;

use Infrastructure\Models\Assembly\Assembly;
use Infrastructure\Models\Assembly\AssemblyType;
use Infrastructure\Models\User\User;
use Database\Seeders\Shared\ImageSeeder;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Seeder;

final class AssemblySeeder extends Seeder
{
    public const NUMBER = 50;

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
            Assembly::factory(self::NUMBER)->make()
                ->sortBy(
                    callback: fn ($sort) => $sort->created_at,
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (Assembly $assembly) {
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
                            ->setModel($assembly)
                            ->run();
                        $this->likeSeeder
                            ->setUsers($users)
                            ->setModel($assembly)
                            ->run();
                        $this->postSeeder
                            ->setUsers($users)
                            ->setModel($assembly)
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
