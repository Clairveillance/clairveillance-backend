<?php

declare(strict_types=1);

namespace App\Core\Resources;

use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Post\Post;
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
                function (UserResource $user) {
                    return collect([
                        'id' => $user->uuid,
                        'type' => 'users',
                        'profile' => $user->profile->uuid,
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
                            'assemblies_with_profile_count' => $user->userAssembliesWithProfile->count(),
                            'assemblies_with_profile' => $user->userAssembliesWithProfile->map(
                                function (AssemblyWithProfile $userAssemblyWithProfile) {
                                    return collect([
                                        'id' => $userAssemblyWithProfile->uuid,
                                        'name' => $userAssemblyWithProfile->name,
                                        'type_id' => $userAssemblyWithProfile->type->uuid,
                                        'type' => $userAssemblyWithProfile->type->name,
                                        'profile' => $userAssemblyWithProfile->profile->uuid,
                                        'likes_count' => $userAssemblyWithProfile->profile->likes->where('is_dislike', 0)->count(),
                                        'dislikes_count' => $userAssemblyWithProfile->profile->likes->where('is_dislike', 1)->count()
                                    ]);
                                }
                            ),
                            'assemblies_count' => $user->userAssemblies->count(),
                            'assemblies' => $user->userAssemblies->map(
                                function (Assembly $userAssembly) {
                                    return collect([
                                        'id' => $userAssembly->uuid,
                                        'name' => $userAssembly->name,
                                        'type_id' => $userAssembly->type->uuid,
                                        'type' => $userAssembly->type->name,
                                        'likes_count' => $userAssembly->likes->where('is_dislike', 0)->count(),
                                        'dislikes_count' => $userAssembly->likes->where('is_dislike', 1)->count()
                                    ]);
                                }
                            ),
                            'posts_count' => $user->posts->count(),
                            'posts' => $user->posts->map(
                                function (Post $post) {
                                    return collect([
                                        'id' => $post->uuid,
                                        'title' => $post->title,
                                        'slug' => $post->slug,
                                        'description' => $post->description,
                                        'type_id' => $post->type->uuid,
                                        'type' => $post->type->name,
                                        'likes_count' => $post->likes->where('is_dislike', 0)->count(),
                                        'dislikes_count' => $post->likes->where('is_dislike', 1)->count(),
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
