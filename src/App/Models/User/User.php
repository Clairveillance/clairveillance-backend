<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Like\Like;
use App\Models\Link\Link;
use App\Models\Post\Post;
use App\Models\Email\Email;
use App\Models\Phone\Phone;
use App\Models\Theme\Theme;
use App\Models\Address\Address;
use App\Models\Comment\Comment;
use App\Models\Profile\Profile;
use App\Models\Assembly\Assembly;
use App\Models\Language\Language;
use App\Models\Sequence\Sequence;
use App\Models\Taxonomy\Taxonomy;
use App\Models\Timezone\Timezone;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use App\Models\Assignment\Assignment;
use App\Models\Connection\Connection;
use App\Models\Appointment\Appointment;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Shared\CustomQueryBuilder;
use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Establishment\Establishment;
use App\Models\Assembly\AssemblyWithProfile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Models\Assignment\AssignmentWithProfile;
use App\Models\Appointment\AppointmentWithProfile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Establishment\EstablishmentWithProfile;

final class User extends Model
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
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'description',
        'language',
        'email',
        'password',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
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

    public function theme()
    {
        return $this->belongsTo(
            related: Theme::class,
            foreignKey: 'theme_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function language()
    {
        return $this->belongsTo(
            related: Language::class,
            foreignKey: 'language_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function timezone()
    {
        return $this->belongsTo(
            related: Timezone::class,
            foreignKey: 'timezone_uuid',
            ownerKey: 'uuid',
            relation: null
        );
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

    public function addresses(): HasMany
    {
        return $this->hasMany(
            related: Address::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(
            related: Appointment::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function appointmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: AppointmentWithProfile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function assemblies(): HasMany
    {
        return $this->hasMany(
            related: Assembly::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function assembliesWithProfile(): HasMany
    {
        return $this->hasMany(
            related: AssemblyWithProfile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(
            related: Assignment::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function assignmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: AssignmentWithProfile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(
            related: Comment::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function connections(): HasMany
    {
        return $this->hasMany(
            related: Connection::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function emails(): HasMany
    {
        return $this->hasMany(
            related: Email::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function establishments(): HasMany
    {
        return $this->hasMany(
            related: Establishment::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function establishmentsWithProfile(): HasMany
    {
        return $this->hasMany(
            related: EstablishmentWithProfile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function likes(): HasMany
    {
        return $this->hasMany(
            related: Like::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function links(): HasMany
    {
        return $this->hasMany(
            related: Link::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function phones(): HasMany
    {
        return $this->hasMany(
            related: Phone::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function posts(): HasMany
    {
        return $this->hasMany(
            related: Post::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(
            related: Profile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function sequences(): HasMany
    {
        return $this->hasMany(
            related: Sequence::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function taxonomies(): HasMany
    {
        return $this->hasMany(
            related: Taxonomy::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    //TODO
    // public function newEloquentBuilder($query): CustomQueryBuilder
    // {
    //     return new CustomQueryBuilder(
    //         query: $query
    //     );
    // }
}
