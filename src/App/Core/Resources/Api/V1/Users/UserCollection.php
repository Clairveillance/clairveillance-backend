<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Users;

use JsonSerializable;
use App\Models\Post\Post;
use App\Models\Assembly\Assembly;
use App\Models\Assignment\Assignment;
use App\Models\Appointment\Appointment;
use App\Models\Assembly\AssemblyHasProfile;
use App\Models\Establishment\Establishment;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Assignment\AssignmentHasProfile;
use App\Core\Resources\Api\V1\Users\UserResource;
use App\Models\Appointment\AppointmentHasProfile;
use App\Models\Establishment\EstablishmentHasProfile;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserCollection extends ResourceCollection
{
    public static $wrap = 'data';

    protected $preserveAllQueryParameters = true;

    public function toArray($request): array|Arrayable|JsonSerializable
    {
        // TODO: Add links to relationships.
        // TODO: Add Resources for eager loaded relationships.
        // FIXME: Surprisingly, the sortBy() method works fine on eager loaded relationships
        // but it fails when we try to use sortByDesc() instead.
        return [
            'succes' => true,
            'status' => 200,
            'message' => 'OK',
            $this::$wrap => $this->collection->map(
                fn (UserResource $user) =>
                collect([
                    'uuid' => $user->uuid,
                    'type' => 'users',
                    'profile_uuid' => $user->relationLoaded('profile') ?
                        $user->profile->uuid : null,
                    // 'likes_total' => $user->profile->likes_total, //NOTE
                    'likes_count' =>
                    $user->relationLoaded('profile') ?
                        $user->profile->likes_count : null,
                    'dislikes_count' =>
                    $user->relationLoaded('profile') ?
                        $user->profile->dislikes_count : null,
                    'attributes' => [
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'description' => $user->description,
                        'email' => $user->email,
                        'created_at' => null ===
                            $user->created_at ?
                            $user->created_at :
                            date(
                                (string) 'Y-m-d H:i:s',
                                strtotime((string) $user->created_at)
                            ),
                        'updated_at' => null ===
                            $user->updated_at ?
                            $user->updated_at :
                            date(
                                (string) 'Y-m-d H:i:s',
                                strtotime((string) $user->updated_at)
                            ),
                        'email_verified_at' => null ===
                            $user->email_verified_at ?
                            $user->email_verified_at :
                            date(
                                (string) 'Y-m-d H:i:s',
                                strtotime((string) $user->email_verified_at)
                            ),
                    ],
                    'relationships' => [
                        'appointments_has_profile_count' =>
                        $user->relationLoaded('appointables_has_profile') ?
                            $user->appointables_has_profile_count : null,
                        'appointments_has_profile' =>
                        $user->relationLoaded('appointables_has_profile') ?
                            $user->appointables_has_profile
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (AppointmentHasProfile $appointable) =>
                                collect([
                                    'uuid' => $appointable->uuid,
                                    'name' => $appointable->name,
                                    'slug' => $appointable->slug,
                                    'description' => $appointable->description,
                                    'note' => $appointable->note,
                                    'start_at' => null === $appointable->start_at ?
                                        $appointable->start_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->start_at)
                                        ),
                                    'end_at' => null === $appointable->end_at ?
                                        $appointable->end_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->end_at)
                                        ),
                                    'published_at' => null === $appointable->published_at ?
                                        $appointable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->published_at)
                                        ),
                                    'type_uuid' => $appointable->relationLoaded('type') ?
                                        $appointable->type->uuid : null,
                                    'type_name' => $appointable->relationLoaded('type') ?
                                        $appointable->type->name : null,
                                    'profile_uuid' => $appointable->relationLoaded('profile') ?
                                        $appointable->profile->uuid : null,
                                    'likes_count' => $appointable->profile->likes_count,
                                    'dislikes_count' => $appointable->profile->dislikes_count,
                                ])
                            ) : null,
                        'appointments_count' =>
                        $user->relationLoaded('appointables') ?
                            $user->appointables_count : null,
                        'appointments' =>
                        $user->relationLoaded('appointables') ?
                            $user->appointables
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (Appointment $appointable) =>
                                collect([
                                    'uuid' => $appointable->uuid,
                                    'name' => $appointable->name,
                                    'description' => $appointable->description,
                                    'note' => $appointable->note,
                                    'start_at' => null === $appointable->start_at ?
                                        $appointable->start_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->start_at)
                                        ),
                                    'end_at' => null === $appointable->end_at ?
                                        $appointable->end_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->end_at)
                                        ),
                                    'published_at' => null === $appointable->published_at ?
                                        $appointable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $appointable->published_at)
                                        ),
                                    'type_uuid' => $appointable->relationLoaded('type') ?
                                        $appointable->type->uuid : null,
                                    'type_name' => $appointable->relationLoaded('type') ?
                                        $appointable->type->name : null,
                                    'likes_count' => $appointable->likes_count,
                                    'dislikes_count' => $appointable->dislikes_count,
                                ])
                            ) : null,
                        'assemblies_has_profile_count' =>
                        $user->relationLoaded('assemblables_has_profile') ?
                            $user->assemblables_has_profile_count : null,
                        'assemblies_has_profile' =>
                        $user->relationLoaded('assemblables_has_profile') ?
                            $user->assemblables_has_profile
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (AssemblyHasProfile $assemblable) =>
                                collect([
                                    'uuid' => $assemblable->uuid,
                                    'name' => $assemblable->name,
                                    'slug' => $assemblable->slug,
                                    'description' => $assemblable->description,
                                    'published_at' => null === $assemblable->published_at ?
                                        $assemblable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $assemblable->published_at)
                                        ),
                                    'type_uuid' => $assemblable->relationLoaded('type') ?
                                        $assemblable->type->uuid : null,
                                    'type_name' => $assemblable->relationLoaded('type') ?
                                        $assemblable->type->name : null,
                                    'profile_uuid' => $assemblable->relationLoaded('profile') ?
                                        $assemblable->profile->uuid : null,
                                    'likes_count' => $assemblable->profile->likes_count,
                                    'dislikes_count' => $assemblable->profile->dislikes_count,
                                ])
                            ) : null,
                        'assemblies_count' =>
                        $user->relationLoaded('assemblables') ?
                            $user->assemblables_count : null,
                        'assemblies' =>
                        $user->relationLoaded('assemblables') ?
                            $user->assemblables
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (Assembly $assemblable) =>
                                collect([
                                    'uuid' => $assemblable->uuid,
                                    'name' => $assemblable->name,
                                    'description' => $assemblable->description,
                                    'published_at' => null === $assemblable->published_at ?
                                        $assemblable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $assemblable->published_at)
                                        ),
                                    'type_uuid' => $assemblable->relationLoaded('type') ?
                                        $assemblable->type->uuid : null,
                                    'type_name' => $assemblable->relationLoaded('type') ?
                                        $assemblable->type->name : null,
                                    'likes_count' => $assemblable->likes_count,
                                    'dislikes_count' => $assemblable->dislikes_count,
                                ])
                            ) : null,
                        'assignments_has_profile_count' =>
                        $user->relationLoaded('assignables_has_profile') ?
                            $user->assignables_has_profile_count : null,
                        'assignments_has_profile' =>
                        $user->relationLoaded('assignables_has_profile') ?
                            $user->assignables_has_profile
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (AssignmentHasProfile $assignable) =>
                                collect([
                                    'uuid' => $assignable->uuid,
                                    'name' => $assignable->name,
                                    'slug' => $assignable->slug,
                                    'description' => $assignable->description,
                                    'published_at' => null === $assignable->published_at ?
                                        $assignable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $assignable->published_at)
                                        ),
                                    'type_uuid' => $assignable->relationLoaded('type') ?
                                        $assignable->type->uuid : null,
                                    'type_name' => $assignable->relationLoaded('type') ?
                                        $assignable->type->name : null,
                                    'profile_uuid' => $assignable->relationLoaded('profile') ?
                                        $assignable->profile->uuid : null,
                                    'likes_count' => $assignable->profile->likes_count,
                                    'dislikes_count' => $assignable->profile->dislikes_count,
                                ])
                            ) : null,
                        'assignments_count' =>
                        $user->relationLoaded('assignables') ?
                            $user->assignables_count : null,
                        'assignments' =>
                        $user->relationLoaded('assignables') ?
                            $user->assignables
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (Assignment $assignable) =>
                                collect([
                                    'uuid' => $assignable->uuid,
                                    'name' => $assignable->name,
                                    'description' => $assignable->description,
                                    'published_at' => null === $assignable->published_at ?
                                        $assignable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $assignable->published_at)
                                        ),
                                    'type_uuid' => $assignable->relationLoaded('type') ?
                                        $assignable->type->uuid : null,
                                    'type_name' => $assignable->relationLoaded('type') ?
                                        $assignable->type->name : null,
                                    'likes_count' => $assignable->likes_count,
                                    'dislikes_count' => $assignable->dislikes_count,
                                ])
                            ) : null,
                        'establishments_has_profile_count' =>
                        $user->relationLoaded('establishables_has_profile') ?
                            $user->establishables_has_profile_count : null,
                        'establishments_has_profile' =>
                        $user->relationLoaded('establishables_has_profile') ?
                            $user->establishables_has_profile
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (EstablishmentHasProfile $establishable) =>
                                collect([
                                    'uuid' => $establishable->uuid,
                                    'name' => $establishable->name,
                                    'slug' => $establishable->slug,
                                    'description' => $establishable->description,
                                    'published_at' => null === $establishable->published_at ?
                                        $establishable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $establishable->published_at)
                                        ),
                                    'type_uuid' => $establishable->relationLoaded('type') ?
                                        $establishable->type->uuid : null,
                                    'type_name' => $establishable->relationLoaded('type') ?
                                        $establishable->type->name : null,
                                    'profile_uuid' => $establishable->relationLoaded('profile') ?
                                        $establishable->profile->uuid : null,
                                    'likes_count' => $establishable->profile->likes_count,
                                    'dislikes_count' => $establishable->profile->dislikes_count,
                                ])
                            ) : null,
                        'establishments_count' =>
                        $user->relationLoaded('establishables') ?
                            $user->establishables_count : null,
                        'establishments' =>
                        $user->relationLoaded('establishables') ?
                            $user->establishables
                            ->sortBy(
                                callback: (array) ['type.name', 'name'],
                                options: (int) SORT_REGULAR,
                                descending: (bool) false
                            )
                            ->map(
                                fn (Establishment $establishable) =>
                                collect([
                                    'uuid' => $establishable->uuid,
                                    'name' => $establishable->name,
                                    'description' => $establishable->description,
                                    'published_at' => null === $establishable->published_at ?
                                        $establishable->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $establishable->published_at)
                                        ),
                                    'type_uuid' => $establishable->relationLoaded('type') ?
                                        $establishable->type->uuid : null,
                                    'type_name' => $establishable->relationLoaded('type') ?
                                        $establishable->type->name : null,
                                    'likes_count' => $establishable->likes_count,
                                    'dislikes_count' => $establishable->dislikes_count,
                                ])
                            ) : null,
                        'posts_count' =>
                        $user->relationLoaded('posts') ?
                            $user->posts_count : null,
                        'posts' =>
                        $user->relationLoaded('posts') ?
                            $user->posts
                            ->map(
                                fn (Post $post)  =>
                                collect([
                                    'uuid' => $post->uuid,
                                    'title' => $post->title,
                                    'slug' => $post->slug,
                                    'description' => $post->description,
                                    'published_at' => null === $post->published_at ?
                                        $post->published_at :
                                        date(
                                            (string) 'Y-m-d H:i:s',
                                            strtotime((string) $post->published_at)
                                        ),
                                    'type_uuid' => $post->relationLoaded('type') ?
                                        $post->type->uuid : null,
                                    'type_name' => $post->relationLoaded('type') ?
                                        $post->type->name : null,
                                    'likes_count' => $post->likes_count,
                                    'dislikes_count' => $post->dislikes_count,
                                    'links' => [
                                        'self' => route((string) 'api.' . config('app.api_version') . '.posts.show', (string) $post->slug),
                                        'parent' => route((string) 'api.' . config('app.api_version') . '.users.show.posts', (string) $user->uuid),
                                    ],
                                ])
                            ) : null,
                    ],
                    'links' => [
                        'self' => route((string) 'api.' . config('app.api_version') . '.users.show', (string) $user->uuid),
                        'parent' => route((string) 'api.' . config('app.api_version') . '.users.index'),
                    ],
                ])
            ),
        ];
    }
}
