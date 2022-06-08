<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Users;

use JsonSerializable;
use App\Support\FormatDate;
use Illuminate\Contracts\Support\Arrayable;
use App\Core\Resources\Api\V1\Users\UserResource;
use App\Core\Resources\Api\V1\Shared\Traits\HasLinks;
use App\Core\Resources\Api\V1\Shared\Traits\HasPosts;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Core\Resources\Api\V1\Shared\Traits\HasProfile;
use App\Core\Resources\Api\V1\Shared\Traits\HasAssemblies;
use App\Core\Resources\Api\V1\Shared\Traits\HasAssignments;
use App\Core\Resources\Api\V1\Shared\Traits\HasAppointments;
use App\Core\Resources\Api\V1\Shared\Traits\HasEstablishments;

final class UserCollection extends ResourceCollection
{
    use HasPosts;
    use HasLinks;
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
                        'created_at' => FormatDate::humanizeYmdHis($user->created_at),
                        'updated_at' => FormatDate::humanizeYmdHis($user->updated_at),
                        'email_verified_at' => FormatDate::humanizeYmdHis($user->email_verified_at),
                    ],
                    // TODO: Add links to profile and relationships.
                    'profile'  => $this->profile($user, 'users'),
                    // FIXME: Surprisingly, the sortBy() method works fine on eager loaded relationships
                    // but it fails when we try to use sortByDesc() instead.
                    'relationships' => [
                        ...$this->appointments($user, 'users'),
                        ...$this->appointments_has_profile($user, 'users'),
                        ...$this->assemblies($user, 'users'),
                        ...$this->assemblies_has_profile($user, 'users'),
                        ...$this->assignments($user, 'users'),
                        ...$this->assignments_has_profile($user, 'users'),
                        ...$this->establishments($user, 'users'),
                        ...$this->establishments_has_profile($user, 'users'),
                        ...$this->posts($user, 'users'),
                    ],
                    'links' => $this->selfLink('.users.show', $user->uuid)->parentLink('.users.index')->getLinks(),
                ])
            ),
        ];
    }
}
