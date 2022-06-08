<?php

declare(strict_types=1);

namespace Infrastructure\Models\Theme;

use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Infrastructure\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

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

    public function users(): HasMany
    {
        return $this->hasMany(
            related: User::class,
            foreignKey: 'theme_uuid',
            localKey: 'uuid'
        );
    }
}
