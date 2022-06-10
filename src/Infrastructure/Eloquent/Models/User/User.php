<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\User;

use Infrastructure\Eloquent\Models\Like\Like;
use Infrastructure\Eloquent\Models\Link\Link;
use Infrastructure\Eloquent\Models\Post\Post;
use Infrastructure\Eloquent\Models\Email\Email;
use Infrastructure\Eloquent\Models\Phone\Phone;
use Infrastructure\Eloquent\Models\Theme\Theme;
use Infrastructure\Eloquent\Models\Address\Address;
use Infrastructure\Eloquent\Models\Comment\Comment;
use Infrastructure\Eloquent\Models\Profile\Profile;
use Infrastructure\Eloquent\Models\Assembly\Assembly;
use Infrastructure\Eloquent\Models\Language\Language;
use Infrastructure\Eloquent\Models\Sequence\Sequence;
use Infrastructure\Eloquent\Models\Taxonomy\Taxonomy;
use Infrastructure\Eloquent\Models\Timezone\Timezone;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Infrastructure\Eloquent\Models\Assignment\Assignment;
use Infrastructure\Eloquent\Models\Connection\Connection;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Infrastructure\Eloquent\Models\Appointment\Appointment;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Illuminate\Notifications\Notifiable;
use Infrastructure\Eloquent\Models\Assembly\AssemblyHasProfile;
use Infrastructure\Eloquent\Models\Establishment\Establishment;
use Infrastructure\Eloquent\Models\Shared\Traits\HasAssignables;
use Infrastructure\Eloquent\Models\Shared\Traits\HasAppointables;
use Infrastructure\Eloquent\Models\Shared\Traits\HasAssemblables;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Eloquent\Models\Assignment\AssignmentHasProfile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasEstablishables;
use Illuminate\Auth\Passwords\CanResetPassword;
use Infrastructure\Eloquent\Models\Appointment\AppointmentHasProfile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Infrastructure\Eloquent\Models\Establishment\EstablishmentHasProfile;

final class User extends Model
{
    use HasUuid;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Authorizable;
    use HasApiTokens;
    use HasAssignables;
    use HasAppointables;
    use HasAssemblables;
    use MustVerifyEmail;
    use Authenticatable;
    use CanResetPassword;
    use HasEstablishables;

    /** @var string */
    protected $morphClass = 'user';

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

    public function getMorphClass(): string
    {
        return $this->morphClass;
    }

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
        // NOTE:  We add orderByDesc() here cause we sort posts by 'published_at' field by default.
        // Maybe it will be better to move this logic to another place if we need to implement a conditional ordering.
        return $this->hasMany(
            related: Post::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        )->orderByDesc('published_at');
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

    public function appointments(): HasMany
    {
        return $this->hasMany(
            related: Appointment::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }

    public function appointmentsHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AppointmentHasProfile::class,
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

    public function assembliesHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AssemblyHasProfile::class,
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

    public function assignmentsHasProfile(): HasMany
    {
        return $this->hasMany(
            related: AssignmentHasProfile::class,
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

    public function establishmentsHasProfile(): HasMany
    {
        return $this->hasMany(
            related: EstablishmentHasProfile::class,
            foreignKey: 'user_uuid',
            localKey: 'uuid'
        );
    }
}
