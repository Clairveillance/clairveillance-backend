<?php

declare(strict_types=1);

namespace App\Models\Image;

use App\Models\Country\Country;
use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Image extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name',
        'type',
        'size',
        'description',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
    ];

    /** @var array<string,string> */
    protected $casts = [
        //
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            related: ImageType::class,
            foreignKey: 'image_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function countries(): HasMany
    {
        return $this->hasMany(
            related: Country::class,
            foreignKey: 'image_uuid',
            localKey: 'uuid'
        );
    }

    public function links(): HasMany
    {
        return $this->hasMany(
            related: Link::class,
            foreignKey: 'image_uuid',
            localKey: 'uuid'
        );
    }

    public function posts(): HasMany
    {
        return $this->hasMany(
            related: Post::class,
            foreignKey: 'image_uuid',
            localKey: 'uuid'
        );
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(
            related: Profile::class,
            foreignKey: 'image_uuid',
            localKey: 'uuid'
        );
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(
            related: Comment::class,
            name: 'commentable',
            type: 'commentable_type',
            id: 'commentable_uuid',
            localKey: 'uuid'
        );
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(
            related: Like::class,
            name: 'likeable',
            type: 'likeable_type',
            id: 'likeable_uuid',
            localKey: 'uuid'
        );
    }
}
