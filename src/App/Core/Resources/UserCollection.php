<?php

declare(strict_types=1);

namespace App\Core\Resources;

use App\Models\Post\Post;
use App\Models\Assembly\Assembly;
use App\Core\Resources\UserResource;
use App\Models\Assignment\Assignment;
use App\Models\Assembly\AssemblyWithProfile;
use App\Models\Assignment\AssignmentWithProfile;
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
                            'created_at' => null === $user->created_at ?
                                $user->created_at :
                                date((string)'Y-m-d H:i:s', strtotime((string)$user->created_at)),
                            'updated_at' => null === $user->updated_at ?
                                $user->updated_at :
                                date((string)'Y-m-d H:i:s', strtotime((string)$user->updated_at)),
                            'email_verified_at' => null === $user->email_verified_at ?
                                $user->email_verified_at :
                                date((string)'Y-m-d H:i:s', strtotime((string)$user->email_verified_at)),
                        ],
                        'relationships' => [
                            'assignments_with_profile_count' => $user->userAssignmentsWithProfile->count(),
                            'assignments_with_profile' => $user->userAssignmentsWithProfile->sortBy((array)['type.name'])->map(
                                function (AssignmentWithProfile $userAssignmentWithProfile) {
                                    return collect([
                                        'id' => $userAssignmentWithProfile->uuid,
                                        'name' => $userAssignmentWithProfile->name,
                                        'slug' => $userAssignmentWithProfile->slug,
                                        'type_id' => $userAssignmentWithProfile->type->uuid,
                                        'type' => $userAssignmentWithProfile->type->name,
                                        'profile' => $userAssignmentWithProfile->profile->uuid,
                                        'likes_count' => $userAssignmentWithProfile->profile->likes->where((string)'is_dislike', (int)0)->count(),
                                        'dislikes_count' => $userAssignmentWithProfile->profile->likes->where((string)'is_dislike', (int)1)->count()
                                    ]);
                                }
                            ),
                            'assignments_count' => $user->userAssignments->count(),
                            'assignments' => $user->userAssignments->sortBy((array)['type.name'])->map(
                                function (Assignment $userAssignment) {
                                    return collect([
                                        'id' => $userAssignment->uuid,
                                        'name' => $userAssignment->name,
                                        'type_id' => $userAssignment->type->uuid,
                                        'type' => $userAssignment->type->name,
                                        'likes_count' => $userAssignment->likes->where((string)'is_dislike', (int)0)->count(),
                                        'dislikes_count' => $userAssignment->likes->where((string)'is_dislike', (int)1)->count()
                                    ]);
                                }
                            ),
                            'assemblies_with_profile_count' => $user->userAssembliesWithProfile->count(),
                            'assemblies_with_profile' => $user->userAssembliesWithProfile->sortBy((array)['type.name'])->map(
                                function (AssemblyWithProfile $userAssemblyWithProfile) {
                                    return collect([
                                        'id' => $userAssemblyWithProfile->uuid,
                                        'name' => $userAssemblyWithProfile->name,
                                        'slug' => $userAssemblyWithProfile->slug,
                                        'type_id' => $userAssemblyWithProfile->type->uuid,
                                        'type' => $userAssemblyWithProfile->type->name,
                                        'profile' => $userAssemblyWithProfile->profile->uuid,
                                        'likes_count' => $userAssemblyWithProfile->profile->likes->where((string)'is_dislike', (int)0)->count(),
                                        'dislikes_count' => $userAssemblyWithProfile->profile->likes->where((string)'is_dislike', (int)1)->count()
                                    ]);
                                }
                            ),
                            'assemblies_count' => $user->userAssemblies->count(),
                            'assemblies' => $user->userAssemblies->sortBy((array)['type.name'])->map(
                                function (Assembly $userAssembly) {
                                    return collect([
                                        'id' => $userAssembly->uuid,
                                        'name' => $userAssembly->name,
                                        'type_id' => $userAssembly->type->uuid,
                                        'type' => $userAssembly->type->name,
                                        'likes_count' => $userAssembly->likes->where((string)'is_dislike', (int)0)->count(),
                                        'dislikes_count' => $userAssembly->likes->where((string)'is_dislike', (int)1)->count()
                                    ]);
                                }
                            ),
                            'published_posts_count' => $user->posts->where((string)'published', (int)1)->count(),
                            'published_posts' => $user->posts->where((string)'published', (int)1)->map(
                                function (Post $post) {
                                    return collect([
                                        'id' => $post->uuid,
                                        'title' => $post->title,
                                        'slug' => $post->slug,
                                        'description' => $post->description,
                                        'published_at' => null === $post->published_at ?
                                            $post->published_at :
                                            date((string)'Y-m-d H:i:s', strtotime((string)$post->published_at)),
                                        'type_id' => $post->type->uuid,
                                        'type' => $post->type->name,
                                        'likes_count' => $post->likes->where((string)'is_dislike', (int)0)->count(),
                                        'dislikes_count' => $post->likes->where((string)'is_dislike', (int)1)->count(),
                                    ]);
                                }
                            ),
                        ],
                        'links' => [
                            'self' => route((string)'api.v1.users.show', (string)$user->uuid),
                            'parent' => route((string)'api.v1.users.index'),
                        ],
                    ]);
                }
            ),
        ];
    }
}
