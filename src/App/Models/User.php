<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User\AbstractUserModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    public function assignments(): MorphToMany
    {
        return $this->morphToMany(Assignment::class, 'assignable');
    }

    public function assemblies(): MorphToMany
    {
        return $this->morphToMany(Assembly::class, 'assemblable');
    }

    public function establisments(): MorphToMany
    {
        return $this->morphToMany(Establishment::class, 'establishable');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_uuid', 'uuid');
    }
}
