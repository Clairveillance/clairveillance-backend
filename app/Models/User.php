<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuid;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    /**
     * @var array<string> $fillable 
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
     * @var array<string> $hidden 
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string,string> $casts 
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
