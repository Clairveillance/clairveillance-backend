<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\AssemblyType;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Assembly\AssemblyHasProfile;

final class AssemblyHasProfileSeeder extends Seeder
{
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
        try {
            AssemblyHasProfile::factory(rand(25, 50))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
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
        }
        dump(__METHOD__ . ' [success]');
    }
}
