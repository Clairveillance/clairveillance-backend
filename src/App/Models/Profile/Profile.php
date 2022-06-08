<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Models\Like\Like;
use App\Models\Post\Post;
use App\Models\User\User;
use App\Models\Image\Image;
use App\Models\Comment\Comment;
use App\Models\Profile\ProfileType;
use App\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\Traits\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Shared\QueryBuilders\CustomQueryBuilder;
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
