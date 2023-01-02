<?php

declare(strict_types=1);

namespace App\Core\V1\Shared\Resources\Traits;

use App\Support\Traits\FormatDates;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasType;
use App\Core\V1\Shared\Resources\Traits\HasLinks;

trait HasPosts
{
    use HasType;
    use HasLinks;
    use FormatDates;

    /**
     * posts
     *
     * @param  mixed $resource
     * @param  string $name
     * @return array
     */
    public function posts(JsonResource $resource, string $name): array
    {
        return (array) [
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
                        'published_at' => $this->dateTimeToString($post->published_at),
                        // 'likes_total' => $post->likes_total ?? null,
                        'likes_count' => $post->likes_count,
                        'dislikes_count' => $post->dislikes_count,
                        'type'  => $this->type($post, 'posts'),
                        'links' => $this->selfLink('.posts.show', $post->slug)->parentLink('.' . $name . '.show.posts', $resource->uuid)->getLinks(),
                    ])
                ) : null,
        ];
    }
}
