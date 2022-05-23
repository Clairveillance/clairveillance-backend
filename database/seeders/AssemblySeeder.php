<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assembly\AssemblyType;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Image\Image;
use App\Models\Image\ImageType;
use App\Models\Like\Like;
use App\Models\Like\LikeType;
use App\Models\User\User;
use Illuminate\Database\Seeder;

final class AssemblySeeder extends Seeder
{
    public function run(): void
    {
        AssemblyWithProfile::factory(100)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($assembly) {
                    $assembly_types = AssemblyType::where('created_at', '<=', $assembly->created_at)->get();
                    $assembly->assembly_type_uuid = $assembly_types->random()->uuid;
                    $users = User::where('created_at', '<=', $assembly->created_at)->get();
                    $assembly->user()->associate($users->random())->save();
                    $likeTypeImageType = ImageType::where('name', 'likeable images')->first();
                    if (!$likeTypeImageType) {
                        $likeTypeImageType = new ImageType(['name' => 'likeable images']);
                        $likeTypeImageType->save();
                    }
                    $likeTypeImage = Image::where('name', 'heart')->first();
                    if (!$likeTypeImage) {
                        $likeTypeImage = new Image([
                            'name' => 'heart',
                            'type' => 'jpg',
                            'size' => '127198271',
                            'description' => 'Just a simple heart',
                        ]);
                        $likeTypeImage->user()->associate($users->random())
                            ->type()->associate($likeTypeImageType)
                            ->save();
                    }
                    $likeType = LikeType::where('name', 'heart')->first();
                    if (!$likeType) {
                        $likeType = new LikeType(['name' => 'heart']);
                        $likeType->image()->associate($likeTypeImage)->save();
                    }
                    for ($i = 0; $i < rand(1, 200); $i++) {
                        try {
                            $like  = new Like();
                            $like->is_dislike = rand(1, 10) > 1 ? 0 : 1;
                            $like->user()->associate($users->random())
                                ->type()->associate($likeType)
                                ->likeable()->associate($assembly->profile)
                                ->save();
                        } catch (\Throwable  $e) {
                        }
                    }
                    for ($i = 0; $i < rand(1, 10); $i++) {
                        try {
                            $assemblies = AssemblyWithProfile::where('uuid', '!=', $assembly->uuid)->get();
                            if ($assemblies->isNotEmpty()) {
                                $assemblable = $assemblies->random();
                                if (
                                    $assemblable->assemblyAssembliesWithProfile->isEmpty()
                                    ||
                                    !$assemblable->assemblyAssembliesWithProfile->contains($assembly)
                                ) {
                                    $assemblable->assemblyAssembliesWithProfile()->attach($assembly);
                                }
                            }
                            $users = User::all();
                            $assemblable = $users->random();
                            if (
                                $assemblable->userAssembliesWithProfile->isEmpty()
                                ||
                                !$assemblable->userAssembliesWithProfile->contains($assembly)
                            ) {
                                $assemblable->userAssembliesWithProfile()->attach($assembly);
                            }
                            $assemblable->save();
                        } catch (\Throwable  $e) {
                        }
                    }
                }
            );
        dump(__METHOD__ . ' [success]');
    }
}
