<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Users;

use JsonSerializable;
use App\Models\Post\Post;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Establishment\Establishment;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Assignment\AssignmentHasProfile;
use App\Core\Resources\Api\V1\Users\UserResource;
use App\Models\Establishment\EstablishmentHasProfile;
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
    public function toArray($request): array|Arrayable|JsonSerializable
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
                            'created_at' => null ===
                                $user->created_at ?
                                $user->created_at :
                                date((string) 'Y-m-d H:i:s', strtotime((string) $user->created_at)),
                            'updated_at' => null ===
                                $user->updated_at ?
                                $user->updated_at :
                                date((string) 'Y-m-d H:i:s', strtotime((string) $user->updated_at)),
                            'email_verified_at' => null ===
                                $user->email_verified_at ?
                                $user->email_verified_at :
                                date((string) 'Y-m-d H:i:s', strtotime((string) $user->email_verified_at)),
                        ],
                        // TODO: Add links to relationships.
                        'relationships' => [
                            'assemblies_has_profile_count' => $user->assemblables_has_profile_count,
                            'assemblies_has_profile' => $user->assemblables_has_profile
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (AssemblyHasProfile $assemblable) {
                                        return collect([
                                            'id' => $assemblable->uuid,
                                            'name' => $assemblable->name,
                                            'slug' => $assemblable->slug,
                                            'type_id' => $assemblable->type->uuid,
                                            'type' => $assemblable->type->name,
                                            'profile' => $assemblable->profile->uuid,
                                            // 'likes_total' => $assemblable->profile->likes_total,
                                            'likes_count' => $assemblable->profile->likes_count,
                                            'dislikes_count' => $assemblable->profile->dislikes_count,
                                        ]);
                                    }
                                ),
                            'assemblies_count' => $user->assemblables_count,
                            'assemblies' => $user->assemblables
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (Assembly $assemblable) {
                                        return collect([
                                            'id' => $assemblable->uuid,
                                            'name' => $assemblable->name,
                                            'type_id' => $assemblable->type->uuid,
                                            'type' => $assemblable->type->name,
                                            // 'likes_total' => $assemblable->likes_total,
                                            'likes_count' => $assemblable->likes_count,
                                            'dislikes_count' => $assemblable->dislikes_count,
                                        ]);
                                    }
                                ),
                            'assignments_has_profile_count' => $user->assignables_has_profile_count,
                            'assignments_has_profile' => $user->assignables_has_profile
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (AssignmentHasProfile $assignable) {
                                        return collect([
                                            'id' => $assignable->uuid,
                                            'name' => $assignable->name,
                                            'slug' => $assignable->slug,
                                            'type_id' => $assignable->type->uuid,
                                            'type' => $assignable->type->name,
                                            'profile' => $assignable->profile->uuid,
                                            // 'likes_total' => $assignable->profile->likes_total,
                                            'likes_count' => $assignable->profile->likes_count,
                                            'dislikes_count' => $assignable->profile->dislikes_count,
                                        ]);
                                    }
                                ),
                            'assignments_count' => $user->assignables_count,
                            'assignments' => $user->assignables
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (Assignment $assignable) {
                                        return collect([
                                            'id' => $assignable->uuid,
                                            'name' => $assignable->name,
                                            'type_id' => $assignable->type->uuid,
                                            'type' => $assignable->type->name,
                                            // 'likes_total' => $assignable->likes_total,
                                            'likes_count' => $assignable->likes_count,
                                            'dislikes_count' => $assignable->dislikes_count,
                                        ]);
                                    }
                                ),
                            'establishments_has_profile_count' => $user->establishables_has_profile_count,
                            'establishments_has_profile' => $user->establishables_has_profile
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (EstablishmentHasProfile $establishable) {
                                        return collect([
                                            'id' => $establishable->uuid,
                                            'name' => $establishable->name,
                                            'slug' => $establishable->slug,
                                            'type_id' => $establishable->type->uuid,
                                            'type' => $establishable->type->name,
                                            'profile' => $establishable->profile->uuid,
                                            // 'likes_total' => $establishable->profile->likes_total,
                                            'likes_count' => $establishable->profile->likes_count,
                                            'dislikes_count' => $establishable->profile->dislikes_count,
                                        ]);
                                    }
                                ),
                            'establishments_count' => $user->establishables_count,
                            'establishments' => $user->establishables
                                // FIXME: Surprisingly, the sortBy() method works fine on child relationships
                                // but it fails when we try to use sortByDesc() instead.
                                ->sortBy(
                                    callback: (array) ['type.name', 'name'],
                                    options: (int) SORT_REGULAR,
                                    descending: (bool) false
                                )
                                ->map(
                                    function (Establishment $establishable) {
                                        return collect([
                                            'id' => $establishable->uuid,
                                            'name' => $establishable->name,
                                            'type_id' => $establishable->type->uuid,
                                            'type' => $establishable->type->name,
                                            // 'likes_total' => $establishable->likes_total,
                                            'likes_count' => $establishable->likes_count,
                                            'dislikes_count' => $establishable->dislikes_count,
                                        ]);
                                    }
                                ),
                            'published_posts_count' => $user->posts_count,
                            'published_posts' => $user->posts->map(
                                function (Post $post) use ($user) {
                                    return collect([
                                        'id' => $post->uuid,
                                        'title' => $post->title,
                                        'slug' => $post->slug,
                                        'description' => $post->description,
                                        'published_at' => null === $post->published_at ?
                                            $post->published_at :
                                            date((string) 'Y-m-d H:i:s', strtotime((string) $post->published_at)),
                                        'type_id' => $post->type->uuid,
                                        'type' => $post->type->name,
                                        'likes_count' => $post->likes->where((string) 'is_dislike', (int) 0)->count(),
                                        'dislikes_count' => $post->likes->where((string) 'is_dislike', (int) 1)->count(),
                                        'links' => [
                                            'self' => route((string) 'api.' . config('app.api_version') . '.posts.show', (string) $post->slug),
                                            'parent' => route((string) 'api.' . config('app.api_version') . '.users.index.posts', (string) $user->uuid),
                                        ],
                                    ]);
                                }
                            ),
                        ],
                        'links' => [
                            'self' => route((string) 'api.' . config('app.api_version') . '.users.show', (string) $user->uuid),
                            'parent' => route((string) 'api.' . config('app.api_version') . '.users.index'),
                        ],
                    ]);
                }
            ),
        ];
    }
}
