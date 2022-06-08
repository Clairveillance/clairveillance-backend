<?php

declare(strict_types=1);

namespace Infrastructure\Models\Link;

use Infrastructure\Models\Image\Image;
use Infrastructure\Models\Link\LinkType;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Link extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'value',
        'name',
        'description',
        'note',
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
            related: LinkType::class,
            foreignKey: 'link_type_uuid',
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
}
