<?php

declare(strict_types=1);

namespace Infrastructure\Models\Taxonomy;

use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class TaxonomyType extends Model
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

    public function taxonomies(): HasMany
    {
        return $this->hasMany(
            related: Taxonomy::class,
            foreignKey: 'taxonomy_type_uuid',
            localKey: 'uuid'
        );
    }
}
