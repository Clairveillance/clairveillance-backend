<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\Post\Post;
use App\Models\User\User;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\Concerns\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Establishment\EstablishmentType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class AbstractEstablishment extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var string */
    protected $table = 'establishments';

    /** @var array<string> */
    protected $fillable = [
        'name',
        'description',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'uuid',
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
            related: EstablishmentType::class,
            foreignKey: 'establishment_type_uuid',
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
}
