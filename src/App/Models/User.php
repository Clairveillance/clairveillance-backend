<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User\AbstractUserModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class User extends AbstractUserModel
{
    /** @var array<string> */
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

    public function assignments(): hasMany
    {
        return $this->hasMany(Assignment::class, 'user_uuid', 'uuid');
    }

    public function assemblies(): hasMany
    {
        return $this->hasMany(Assembly::class, 'user_uuid', 'uuid');
    }

    public function establishments(): hasMany
    {
        return $this->hasMany(Establishment::class, 'user_uuid', 'uuid');
    }

    public function posts(): hasMany
    {
        return $this->hasMany(Post::class, 'author_uuid', 'uuid');
    }
}
