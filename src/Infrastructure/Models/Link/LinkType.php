<?php

declare(strict_types=1);

namespace Infrastructure\Models\Link;

use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class LinkType extends Model
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

    public function links(): HasMany
    {
        return $this->hasMany(
            related: Link::class,
            foreignKey: 'link_type_uuid',
            localKey: 'uuid'
        );
    }
}
