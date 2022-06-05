<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use App\Models\Post\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasType;

trait HasPosts
{
    use HasType;

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
                        'published_at' => $this->getFormattedDate($post->published_at),
                        'likes_count' => $post->likes_count,
                        'dislikes_count' => $post->dislikes_count,
                        'links' => [
                            'self' => route((string) 'api.' . config('app.api_version') . '.posts.show', (string) $post->slug),
                            'parent' => route((string) 'api.' . config('app.api_version') . '.' . $name . '.show.posts', (string) $resource->uuid),
                        ],
                        'type'  => $this->type($post),
                    ])
                ) : null,
        ];
    }
}
