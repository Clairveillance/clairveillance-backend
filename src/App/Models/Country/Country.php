<?php

declare(strict_types=1);

namespace App\Models\Country;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Country extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name',
        'code',
        'phone_prefix'
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

    public function image(): BelongsTo
    {
        return $this->belongsTo(
            related: Image::class,
            foreignKey: 'image_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(
            related: Address::class,
            foreignKey: 'country_uuid',
            localKey: 'uuid'
        );
    }

    public function phones(): HasMany
    {
        return $this->hasMany(
            related: Phone::class,
            foreignKey: 'country_uuid',
            localKey: 'uuid'
        );
    }
}