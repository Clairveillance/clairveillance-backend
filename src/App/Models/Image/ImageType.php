<?php

declare(strict_types=1);

namespace App\Models\Image;

use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\Concerns\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ImageType extends Model
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

    public function images(): HasMany
    {
        return $this->hasMany(
            related: Image::class,
            foreignKey: 'image_type_uuid',
            localKey: 'uuid'
        );
    }
}
