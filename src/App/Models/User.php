<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Concerns\HasFactory;
use App\Models\Builders\UserBuilder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
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
        'id',
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
