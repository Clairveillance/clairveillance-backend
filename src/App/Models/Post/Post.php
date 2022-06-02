<?php

declare(strict_types=1);

namespace App\Models\Post;

use App\Models\Comment\Comment;
use App\Models\Image\Image;
use App\Models\Like\Like;
use App\Models\Post\PostType;
use App\Models\Post\QueryBuilder\PostQueryBuilder;
use App\Models\Shared\Concerns\Traits\HasFactory;
use App\Models\Shared\Concerns\Traits\HasSlug;
use App\Models\Shared\Concerns\Traits\HasUuid;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasUuid;
    use HasSlug;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $morphClass = 'post';

    /** @var array<string> */
    protected $fillable = [
        'title',
        'description',
        'body',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected function slugSources(): array
    {
        return [
            'source' => 'title',
            'params' => '-by-'.$this->user->username,
        ];
    }

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
            related: PostType::class,
            foreignKey: 'post_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function postable(): MorphTo
    {
        return $this->morphTo(
            name: __FUNCTION__,
            type: 'postable_type',
            id: 'postable_uuid',
            ownerKey: 'uuid'
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

    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder(
            query: $query
        );
    }
}
