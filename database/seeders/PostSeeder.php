<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post\Post;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(1000)->create();
        dump(__METHOD__ . ' [success]');
    }
}
