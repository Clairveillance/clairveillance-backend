<?php

declare(strict_types=1);

namespace App\Core\Resources;

use App\Core\Resources\UserResource;
use App\Models\Assembly\Assembly;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Assignment\Assignment;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Establishment\Establishment;
use App\Models\Establishment\EstablishmentWithProfile;
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
                                ->sortBy((array) ['type.name'])
                                ->map(
                                    function (AssemblyHasProfile $assemblable) {
                                        return collect([
                                            'id' => $assemblable->uuid,
                                            'name' => $assemblable->name,
                                            'slug' => $assemblable->slug,
                                            'type_id' => $assemblable->type->uuid,
                                            'type' => $assemblable->type->name,
                                            'profile' => $assemblable->profile->uuid,
                                            'likes_count' => $assemblable->profile->likes
                                                ->where((string) 'is_dislike', (int) 0)
                                                ->count(),
                                            'dislikes_count' => $assemblable->profile->likes
                                                ->where((string) 'is_dislike', (int) 1)
                                                ->count(),
                                        ]);
                                    }
                                ),
                            'assemblies_count' => $user->assemblables_count,
                            'assemblies' => $user->assemblables
                                ->sortBy((array) ['type.name'])
                                ->map(
                                    function (Assembly $assemblable) {
                                        return collect([
                                            'id' => $assemblable->uuid,
                                            'name' => $assemblable->name,
                                            'type_id' => $assemblable->type->uuid,
                                            'type' => $assemblable->type->name,
                                            'likes_count' => $assemblable->likes
                                                ->where((string) 'is_dislike', (int) 0)
                                                ->count(),
                                            'dislikes_count' => $assemblable->likes
                                                ->where((string) 'is_dislike', (int) 1)
                                                ->count(),
                                        ]);
                                    }
                                ),
                            'assignments_with_profile_count' => $user->userAssignmentsWithProfile->count(),
                            'assignments_with_profile' => $user->userAssignmentsWithProfile->sortBy((array) ['type.name'])->map(
                                function (AssignmentWithProfile $userAssignmentWithProfile) {
                                    return collect([
                                        'id' => $userAssignmentWithProfile->uuid,
                                        'name' => $userAssignmentWithProfile->name,
                                        'slug' => $userAssignmentWithProfile->slug,
                                        'type_id' => $userAssignmentWithProfile->type->uuid,
                                        'type' => $userAssignmentWithProfile->type->name,
                                        'profile' => $userAssignmentWithProfile->profile->uuid,
                                        'likes_count' => $userAssignmentWithProfile->profile->likes->where((string) 'is_dislike', (int) 0)->count(),
                                        'dislikes_count' => $userAssignmentWithProfile->profile->likes->where((string) 'is_dislike', (int) 1)->count(),
                                    ]);
                                }
                            ),
                            'assignments_count' => $user->userAssignments->count(),
                            'assignments' => $user->userAssignments->sortBy((array) ['type.name'])->map(
                                function (Assignment $userAssignment) {
                                    return collect([
                                        'id' => $userAssignment->uuid,
                                        'name' => $userAssignment->name,
                                        'type_id' => $userAssignment->type->uuid,
                                        'type' => $userAssignment->type->name,
                                        'likes_count' => $userAssignment->likes->where((string) 'is_dislike', (int) 0)->count(),
                                        'dislikes_count' => $userAssignment->likes->where((string) 'is_dislike', (int) 1)->count(),
                                    ]);
                                }
                            ),
                            'establishments_with_profile_count' => $user->userEstablishmentsWithProfile->count(),
                            'establishments_with_profile' => $user->userEstablishmentsWithProfile->sortBy((array) ['type.name'])->map(
                                function (EstablishmentWithProfile $userEstablishmentWithProfile) {
                                    return collect([
                                        'id' => $userEstablishmentWithProfile->uuid,
                                        'name' => $userEstablishmentWithProfile->name,
                                        'slug' => $userEstablishmentWithProfile->slug,
                                        'type_id' => $userEstablishmentWithProfile->type->uuid,
                                        'type' => $userEstablishmentWithProfile->type->name,
                                        'profile' => $userEstablishmentWithProfile->profile->uuid,
                                        'likes_count' => $userEstablishmentWithProfile->profile->likes->where((string) 'is_dislike', (int) 0)->count(),
                                        'dislikes_count' => $userEstablishmentWithProfile->profile->likes->where((string) 'is_dislike', (int) 1)->count(),
                                    ]);
                                }
                            ),
                            'establishments_count' => $user->userEstablishments->count(),
                            'establishments' => $user->userEstablishments->sortBy((array) ['type.name'])->map(
                                function (Establishment $userEstablishment) {
                                    return collect([
                                        'id' => $userEstablishment->uuid,
                                        'name' => $userEstablishment->name,
                                        'type_id' => $userEstablishment->type->uuid,
                                        'type' => $userEstablishment->type->name,
                                        'likes_count' => $userEstablishment->likes->where((string) 'is_dislike', (int) 0)->count(),
                                        'dislikes_count' => $userEstablishment->likes->where((string) 'is_dislike', (int) 1)->count(),
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
                                            'self' => route((string) 'api.' . env('API_VERSION', 'v1') . '.posts.show', (string) $post->slug),
                                            'parent' => route((string) 'api.' . env('API_VERSION', 'v1') . '.users.index.posts', (string) $user->uuid),
                                        ],
                                    ]);
                                }
                            ),
                        ],
                        'links' => [
                            'self' => route((string) 'api.' . env('API_VERSION', 'v1') . '.users.show', (string) $user->uuid),
                            'parent' => route((string) 'api.' . env('API_VERSION', 'v1') . '.users.index'),
                        ],
                    ]);
                }
            ),
        ];
    }
}
