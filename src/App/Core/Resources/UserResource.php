<?php

declare(strict_types=1);

namespace App\Core\Resources;

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
                'avatar' => $this->avatar,
                'description' => $this->description,
                'company' => $this->company,
                'website' => $this->website,
                'country' => $this->country,
                'state' => $this->state,
                'city' => $this->city,
                'zip' => $this->zip,
                'address' => $this->address,
                'address_2' => $this->address_2,
                'phone' => $this->phone,
                'theme' => $this->theme,
                'language' => $this->language,
                'email' => $this->email,
                'created_at' => null === $this->created_at ? $this->created_at : date('Y-m-d H:i:s', strtotime((string) $this->created_at)),
                'updated_at' => null === $this->updated_at ? $this->updated_at : date('Y-m-d H:i:s', strtotime((string) $this->updated_at)),
                'email_verified_at' => null === $this->email_verified_at ? $this->email_verified_at : date('Y-m-d H:i:s', strtotime((string) $this->email_verified_at)),
            ],
            'relationships' => $this->posts->map(
                function ($post) {
                    return collect([
                        'id' => $post->uuid,
                        'type' => 'posts',
                        'attributes' => [
                            'slug' => $post->slug,
                            'title' => $post->title,
                            'image' => $post->image,
                            'description' => $post->description,
                            'body' => $post->body,
                            'published' => $post->published,
                            'published_at' => null === $post->published_at ? $post->published_at : date('Y-m-d H:i:s', strtotime((string) $post->published_at)),
                            'created_at' => null === $post->created_at ? $post->created_at : date('Y-m-d H:i:s', strtotime((string) $post->created_at)),
                            'updated_at' => null === $post->updated_at ? $post->updated_at : date('Y-m-d H:i:s', strtotime((string) $post->updated_at)),
                        ],
                    ]);
                }
            ),
            'links' => [
                'self' => route('api.v1.users.show', $this->uuid),
                'parent' => route('api.v1.users.index'),
            ],
        ];
    }
}
