<?php

declare(strict_types=1);

namespace App\Core\V1\Users\Resources;

use JsonSerializable;
use App\Support\Traits\FormatDates;
use Infrastructure\Eloquent\Models\Post\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Core\V1\Shared\Resources\Traits\HasLinks;
use App\Core\V1\Shared\Resources\Traits\HasPosts;
use App\Core\V1\Shared\Resources\Traits\HasProfile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Infrastructure\Eloquent\Models\Profile\Profile;
use App\Core\V1\Shared\Resources\Traits\HasAssemblies;
use App\Core\V1\Shared\Resources\Traits\HasAssignments;
use App\Core\V1\Shared\Resources\Traits\HasAppointments;
use App\Core\V1\Shared\Resources\Traits\HasEstablishments;

/**
 * UserResource
 * 
 * @property string $uuid
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $description
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $email_verified_at
 * @property Profile $profile
 * @property HasMany $posts
 */
final class UserResource extends JsonResource
{
    use HasPosts;
    use HasLinks;
    use HasProfile;
    use HasAssemblies;
    use HasAssignments;
    use HasAppointments;
    use HasEstablishments;
    use FormatDates;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
    {
        return (array) [
            'id' => $this->uuid,
            'type' => 'users',
            'attributes' => [
                'username' => $this->username,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'description' => $this->description,
                'email' => $this->email,
                'created_at' => null === $this->created_at ? $this->created_at : date('Y-m-d H:i:s', strtotime((string) $this->created_at)),
                'updated_at' => null === $this->updated_at ? $this->updated_at : date('Y-m-d H:i:s', strtotime((string) $this->updated_at)),
                'email_verified_at' => null === $this->email_verified_at ? $this->email_verified_at : date('Y-m-d H:i:s', strtotime((string) $this->email_verified_at)),
            ],
            'profile' => [
                'id' => $this->profile->uuid,
                'type' => $this->profile->type->name,
                'type_id' => $this->profile->type->uuid,
                'attributes' => [
                    'image' => $this->profile->image, // TODO
                    'created_at' => null === $this->profile->created_at ? $this->profile->created_at : date('Y-m-d H:i:s', strtotime((string) $this->profile->created_at)),
                    'updated_at' => null === $this->profile->updated_at ? $this->profile->updated_at : date('Y-m-d H:i:s', strtotime((string) $this->profile->updated_at)),
                ],
                // TODO : Add links for profile.
                // 'links' => [
                //     'self' => route('api.'.config('app.api_version').'.profile.show', $this->profile->uuid),
                //     'parent' => route('api.'.config('app.api_version').'.profile.index'),
                // ],
            ],
            'relationships' => [
                ...$this->appointments($this, 'users'),
                ...$this->appointments_has_profile($this, 'users'),
                ...$this->assemblies($this, 'users'),
                ...$this->assemblies_has_profile($this, 'users'),
                ...$this->assignments($this, 'users'),
                ...$this->assignments_has_profile($this, 'users'),
                ...$this->establishments($this, 'users'),
                ...$this->establishments_has_profile($this, 'users'),
                ...$this->posts($this, 'users'),
            ],
            'links' => [
                'self' => route('api.' . config('app.api_version') . '.users.show', $this->uuid),
                'parent' => route('api.' . config('app.api_version') . '.users.index'),
            ],
        ];
    }
}
