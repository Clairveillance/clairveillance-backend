<?php

declare(strict_types=1);

namespace App\Models\Like;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Like extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'is_dislike',
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
            related: LikeType::class,
            foreignKey: 'like_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo(
            name: __FUNCTION__,
            type: 'likeable_type',
            id: 'likeable_uuid',
            ownerKey: 'uuid'
        );
    }
}
