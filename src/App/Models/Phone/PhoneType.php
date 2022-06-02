<?php

declare(strict_types=1);

namespace App\Models\Phone;

use App\Models\Shared\Traits\HasFactory;
use App\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class PhoneType extends Model
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

    public function phones(): HasMany
    {
        return $this->hasMany(
            related: Phone::class,
            foreignKey: 'phone_type_uuid',
            localKey: 'uuid'
        );
    }
}
