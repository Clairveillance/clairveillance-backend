<?php

declare(strict_types=1);

namespace App\Core\Resources;

use App\Models\Post\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
    {
        return [
            'id' => $this->uuid,
            'type' => 'users',
            'attributes' => [
                'username' => $this->username,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'description' => $this->description,
                'email' => $this->email,
                'created_at' => null === $this->created_at ? $this->created_at : date('Y-m-d H:i:s', strtotime((string) $this->created_at)),
                'updated_at' => null === $this->updated_at ? $this->updated_at : date('Y-m-d H:i:s', strtotime((string) $this->updated_at)),
                'email_verified_at' => null === $this->email_verified_at ? $this->email_verified_at : date('Y-m-d H:i:s', strtotime((string) $this->email_verified_at)),
            ],
            'profile' => [
                'id' => $this->profile->uuid,
                'type' => $this->profile->type->name,
                'type_id' => $this->profile->type->uuid,
                'attributes' => [
                    'image' => $this->profile->image, // TODO
                    'created_at' => null === $this->profile->created_at ? $this->profile->created_at : date('Y-m-d H:i:s', strtotime((string) $this->profile->created_at)),
                    'updated_at' => null === $this->profile->updated_at ? $this->profile->updated_at : date('Y-m-d H:i:s', strtotime((string) $this->profile->updated_at)),
                ],
                // TODO : Add links for profile.
                // 'links' => [
                //     'self' => route('api.'.env('API_VERSION', 'v1').'.profile.show', $this->profile->uuid),
                //     'parent' => route('api.'.env('API_VERSION', 'v1').'.profile.index'),
                // ],
            ],
            'relationships' => [
                'posts_count' => $this->posts->count(),
                'posts' => $this->posts->map(
                    function (Post $post) {
                        return collect([
                            'id' => $post->uuid,
                            'type' => $post->type->name,
                            'type_id' => $post->type->uuid,
                            'attributes' => [
                                'slug' => $post->slug,
                                'title' => $post->title,
                                'description' => $post->description,
                                'body' => $post->body,
                                'published' => $post->published,
                                'published_at' => null === $post->published_at ? $post->published_at : date('Y-m-d H:i:s', strtotime((string) $post->published_at)),
                                'created_at' => null === $post->created_at ? $post->created_at : date('Y-m-d H:i:s', strtotime((string) $post->created_at)),
                                'updated_at' => null === $post->updated_at ? $post->updated_at : date('Y-m-d H:i:s', strtotime((string) $post->updated_at)),
                            ],
                            // TODO : Add links for relationships.
                            // 'links' => [
                            //     'self' => route('api.'.env('API_VERSION', 'v1').'.posts.show', $post->uuid),
                            //     'parent' => route('api.'.env('API_VERSION', 'v1').'.posts.index'),
                            // ],
                        ]);
                    }
                ),
            ],
            'links' => [
                'self' => route('api.' . env('API_VERSION', 'v1') . '.users.show', $this->uuid),
                'parent' => route('api.' . env('API_VERSION', 'v1') . '.users.index'),
            ],
        ];
    }
}
