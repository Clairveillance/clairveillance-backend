<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Users;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use App\Core\Resources\Api\V1\Users\UserResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasPosts;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Core\Resources\Api\V1\Shared\Traits\HasFilters;
use App\Core\Resources\Api\V1\Shared\Traits\HasProfile;
use App\Core\Resources\Api\V1\Shared\Traits\HasAssemblies;
use App\Core\Resources\Api\V1\Shared\Traits\HasAssignments;
use App\Core\Resources\Api\V1\Shared\Traits\HasAppointments;
use App\Core\Resources\Api\V1\Shared\Traits\HasEstablishments;

final class UserCollection extends ResourceCollection
{
    use HasPosts;
    use HasFilters;
    use HasProfile;
    use HasAssemblies;
    use HasAssignments;
    use HasAppointments;
    use HasEstablishments;

    public static $wrap = 'data';

    protected $preserveAllQueryParameters = true;

    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'succes' => true,
            'status' => 200,
            'message' => 'OK',
            $this::$wrap => $this->collection->map(
                fn (UserResource $user) =>
                collect([
                    'uuid' => $user->uuid,
                    'type' => 'users',
                    'attributes' => [
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'description' => $user->description,
                        'email' => $user->email,
                        'created_at' => $this->getFormattedDate($user->created_at),
                        'updated_at' => $this->getFormattedDate($user->updated_at),
                        'email_verified_at' => $this->getFormattedDate($user->email_verified_at),
                    ],
                    // TODO: Add links to profile and relationships.
                    'profile'  => $this->profile($user),
                    // FIXME: Surprisingly, the sortBy() method works fine on eager loaded relationships
                    // but it fails when we try to use sortByDesc() instead.
                    'relationships' => [
                        ...$this->appointments($user),
                        ...$this->appointments_has_profile($user),
                        ...$this->assemblies($user),
                        ...$this->assemblies_has_profile($user),
                        ...$this->assignments($user),
                        ...$this->assignments_has_profile($user),
                        ...$this->establishments($user),
                        ...$this->establishments_has_profile($user),
                        ...$this->posts($user, 'users'),
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
