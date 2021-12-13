<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;

final class PostTypeSeeder extends Seeder
{
    public function run(): void
    {
        PostType::factory(25)->make()
            ->sortBy(
                callback: function ($sort) {
                    return $sort->created_at;
                },
                options: SORT_REGULAR,
                descending: false
            )
            ->each(
                callback: function ($post_type) {
                    $post_type->save();
                }
            );
    }
}
