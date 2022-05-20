<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasUuid;
use App\Models\User\UserBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

abstract class AbstractUserModel extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use HasUuid;
    use HasFactory;
    use Notifiable;
    use HasProfile;
    use SoftDeletes;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
    use HasApiTokens;

    /** @var array<string> */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function profile(): MorphOne
    {
        return $this->morphOne(
            related: Profile::class,
            name: 'profilable',
            type: 'profilable_type',
            id: 'profilable_uuid',
            localKey: 'uuid'
        );
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder(
            query: $query
        );
    }
}
