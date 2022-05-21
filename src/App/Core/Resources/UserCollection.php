<?php

declare(strict_types=1);

namespace App\Core\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserCollection extends ResourceCollection
{
    public static $wrap = 'data';

    protected $preserveAllQueryParameters = true;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable;
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return [
            'succes' => true,
            'status' => 200,
            'message' => 'OK',
            $this::$wrap => $this->collection->map(
                function ($user) {
                    return collect([
                        'id' => $user->uuid,
                        'type' => 'user',
                        'attributes' => [
                            'username' => $user->username,
                            'firstname' => $user->firstname,
                            'lastname' => $user->lastname,
                            'description' => $user->description,
                            'email' => $user->email,
                            'created_at' => null === $user->created_at ? $user->created_at : date('Y-m-d H:i:s', strtotime((string) $user->created_at)),
                            'updated_at' => null === $user->updated_at ? $user->updated_at : date('Y-m-d H:i:s', strtotime((string) $user->updated_at)),
                            'email_verified_at' => null === $user->email_verified_at ? $user->email_verified_at : date('Y-m-d H:i:s', strtotime((string) $user->email_verified_at)),
                        ],
                        'relationships' => [
                            'posts_count' => $user->posts->count(),
                            'posts' =>
                            $user->posts->map(
                                function ($post) {
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
                                        //     'self' => route('api.v1.posts.show', $post->uuid),
                                        //     'parent' => route('api.v1.posts.index'),
                                        // ],
                                    ]);
                                }
                            ),

                        ],
                        'links' => [
                            'self' => route('api.v1.users.show', $user->uuid),
                            'parent' => route('api.v1.users.index'),
                        ],
                    ]);
                }
            ),
        ];
    }
}
