<?php

declare(strict_types=1);

namespace Domain\Shared\Models;

use Domain\Shared\Models\Builders\UserBuilder;
use Domain\Shared\Models\Concerns\HasUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuid;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'uuid',
        'username',
        'firstname',
        'lastname',
        'avatar',
        'description',
        'company',
        'website',
        'country',
        'state',
        'city',
        'zip',
        'address',
        'address_2',
        'phone',
        'theme',
        'language',
        'email',
        'password',
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder(
            query: $query
        );
    }
}
