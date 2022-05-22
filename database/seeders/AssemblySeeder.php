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
                    $assembly->user()->associate($users->random());
                    $assembly->save();
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
                        $likeTypeImage->user()->associate($users->random());
                        $likeTypeImage->type()->associate($likeTypeImageType);
                        $likeTypeImage->save();
                    }
                    $likeType = LikeType::where('name', 'heart')->first();
                    if (!$likeType) {
                        $likeType = new LikeType(['name' => 'heart']);
                        $likeType->image()->associate($likeTypeImage);
                        $likeType->save();
                    }
                    $like  = new Like();
                    $like->is_dislike = rand(0, 1);
                    $like->user()->associate($users->random());
                    $like->type()->associate($likeType);
                    // dd($assembly->profile);
                    $like->likeable()->associate($assembly->profile);
                    $like->save();
                    $assemblies = AssemblyWithProfile::all();
                    for ($i = 0; $i < rand(1, 10); $i++) {
                        $assemblable = $assemblies->random();
                        if (
                            $assemblable !== $assembly &&
                            $assemblable !== $assembly->assemblyAssemblablesWithProfile
                        ) {
                            $assembly->assemblyAssemblablesWithProfile()->attach($assemblable);
                        }
                    }
                    $assembly->save();
                    $users = User::all();
                    for ($i = 0; $i < rand(1, 10); $i++) {
                        $assemblable = $users->random();
                        if (
                            $assemblable !== $assembly->userAssemblablesWithProfile
                        ) {
                            $assembly->userAssemblablesWithProfile()->attach($assemblable);
                        }
                    }
                    $assembly->save();
                }
            );
        dump(__METHOD__ . ' [success]');
    }
}
