<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Resources;

use JsonSerializable;
use App\Support\Traits\FormatDates;
use Illuminate\Contracts\Support\Arrayable;
use App\Core\V1\Users\Resources\UserResource;
use App\Core\V1\Shared\Resources\Traits\HasLinks;
use App\Core\V1\Shared\Resources\Traits\HasPosts;
use App\Core\V1\Shared\Resources\Traits\HasProfile;
use App\Core\V1\Shared\Resources\Traits\HasAssemblies;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Core\V1\Shared\Resources\Traits\HasAssignments;
use App\Core\V1\Shared\Resources\Traits\HasAppointments;
use App\Core\V1\Shared\Resources\Traits\HasEstablishments;

/**
 * UserCollection
 */
final class UserCollection extends ResourceCollection
{
    use HasPosts;
    use HasLinks;
    use HasProfile;
    use HasAssemblies;
    use HasAssignments;
    use HasAppointments;
    use HasEstablishments;
    use FormatDates;

    public static $wrap = 'data';

    protected $preserveAllQueryParameters = true;

    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return (array) [
            'succes' => true,
            'status' => 200,
            'message' => 'OK',
            $this::$wrap => $this->collection->map(
                fn (UserResource $user) =>
                collect([
                    'uuid' => $user->uuid,
                    'type' => 'user',
                    'attributes' => [
                        'username' => $user->username,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'description' => $user->description,
                        'email' => $user->email,
                        'created_at' => $this->dateTimeToString($user->created_at),
                        'updated_at' => $this->dateTimeToString($user->updated_at),
                        'email_verified_at' => $this->dateTimeToString($user->email_verified_at),
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
