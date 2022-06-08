<?php

declare(strict_types=1);

namespace Infrastructure\Models\Like;

use Infrastructure\Models\Image\Image;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class LikeType extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name',
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

    public function likes(): HasMany
    {
        return $this->hasMany(
            related: Like::class,
            foreignKey: 'like_type_uuid',
            localKey: 'uuid'
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
}
