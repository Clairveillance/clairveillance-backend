<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Image;

use Infrastructure\Eloquent\Models\Comment\Comment;
use Infrastructure\Eloquent\Models\Country\Country;
use Infrastructure\Eloquent\Models\Image\ImageType;
use Infrastructure\Eloquent\Models\Like\Like;
use Infrastructure\Eloquent\Models\Link\Link;
use Infrastructure\Eloquent\Models\Post\Post;
use Infrastructure\Eloquent\Models\Profile\Profile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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

    public function imageables(Model $model): MorphToMany
    {
        return $this->morphedByMany(
            related: $model,
            name: 'imageable',
            table: null,
            foreignPivotKey: 'image_uuid',
            relatedPivotKey: 'imageable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid'
        );
    }
}
