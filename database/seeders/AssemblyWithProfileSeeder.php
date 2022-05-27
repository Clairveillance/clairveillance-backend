<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyType;
use Database\Seeders\Shared\LikeSeeder;
use Database\Seeders\Shared\PostSeeder;
use Database\Seeders\Shared\TypeSeeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeders\Shared\ImageSeeder;
use App\Models\Assembly\AssemblyWithProfile;

final class AssemblyWithProfileSeeder extends Seeder
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
            AssemblyWithProfile::factory(rand(20, 40))->make()
                ->sortBy(
                    callback: function ($sort) {
                        return $sort->created_at;
                    },
                    options: SORT_REGULAR,
                    descending: false
                )
                ->each(
                    callback: function (AssemblyWithProfile $assembly) {
                        $assembly_types = AssemblyType::where('created_at', '<=', $assembly->created_at)->get();
                        $users = User::where('created_at', '<=', $assembly->created_at)->get();
                        $assembly->user()->associate($users->random())
                            ->type()->associate($assembly_types->random())
                            ->save();
                        $this->imageSeeder->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $this->likeSeeder->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $this->postSeeder->setUsers($users)
                            ->setModel($assembly->profile)
                            ->run();
                        $randomAssemblies = rand(1, 3);
                        match ((int) $randomAssemblies) {
                            1 => $this->assemblables($assembly, new Assembly),
                            2 => $this->assemblables($assembly, new AssemblyWithProfile),
                            3 => $this->assemblables($assembly, new User),
                        };
                    }
                );
        } catch (\Throwable $e) {
        }
        dump(__METHOD__ . ' [success]');
    }

    private function assemblables(AssemblyWithProfile $assembly, Model $model): void
    {
        for ($i = 0; $i < rand(1, 25); $i++) {
            try {
                $models = $model::where('uuid', '!=', $assembly->uuid)->get();
                if ($models->isNotEmpty()) {
                    $assemblable = $models->random();
                    if (
                        $assembly->assemblables($model)->get()->isEmpty()
                        ||
                        !$assembly->assemblables($model)->get()->contains($assemblable)
                    ) {
                        $assembly->assemblables($model)->attach($assemblable);
                    }
                }
            } catch (\Throwable  $e) {
            }
        }
    }
}
