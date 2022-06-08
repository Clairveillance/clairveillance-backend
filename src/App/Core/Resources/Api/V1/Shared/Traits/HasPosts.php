<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Post\Post;
use App\Support\FormatDate;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;
use App\Core\Resources\Api\V1\Shared\Traits\HasLinks;

trait HasPosts
{
    use HasType;
    use HasLinks;

    public function posts(JsonResource $resource, string $name): array
    {
        return [
            'posts_count' => $resource->posts_count ?? null,
            'posts' =>
            $resource->relationLoaded('posts') ?
                $resource->posts
                ->map(
                    fn (Post $post)  =>
                    collect([
                        'uuid' => $post->uuid,
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'description' => $post->description,
                        'published_at' => FormatDate::humanizeYmdHis($post->published_at),
                        'likes_count' => $post->likes_count,
                        'dislikes_count' => $post->dislikes_count,
                        'type'  => $this->type($post, 'posts'),
                        'links' => $this->selfLink('.posts.show', $post->slug)->parentLink('.' . $name . '.show.posts', $resource->uuid)->getLinks(),
                    ])
                ) : null,
        ];
    }
}
