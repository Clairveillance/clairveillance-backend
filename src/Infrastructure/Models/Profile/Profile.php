<?php

declare(strict_types=1);

namespace Infrastructure\Models\Profile;

use Infrastructure\Models\Like\Like;
use Infrastructure\Models\Post\Post;
use Infrastructure\Models\User\User;
use Infrastructure\Models\Image\Image;
use Infrastructure\Models\Comment\Comment;
use Infrastructure\Models\Profile\ProfileType;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Infrastructure\Models\Shared\QueryBuilders\CustomQueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class Profile extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $morphClass = 'profile';

    /** @var array<string> */
    protected $fillable = [
        'published',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
    ];

    public function getMorphClass(): string
    {
        return $this->morphClass;
    }

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
            related: ProfileType::class,
            foreignKey: 'profile_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(
            related: Image::class,
            foreignKey: 'image_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function profilable(): MorphTo
    {
        return $this->morphTo(
            name: __FUNCTION__,
            type: 'profilable_type',
            id: 'profilable_uuid',
            ownerKey: 'uuid'
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

    public function posts(): MorphMany
    {
        return $this->morphMany(
            related: Post::class,
            name: 'postable',
            type: 'postable_type',
            id: 'postable_uuid',
            localKey: 'uuid'
        );
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(
            related: Image::class,
            name: 'imageable',
            table: null,
            foreignPivotKey: 'imageable_uuid',
            relatedPivotKey: 'image_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }

    public function newEloquentBuilder($query): CustomQueryBuilder
    {
        return new CustomQueryBuilder(
            query: $query
        );
    }
}
