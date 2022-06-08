<?php

declare(strict_types=1);

namespace Infrastructure\Models\Phone;

use Infrastructure\Models\Country\Country;
use Infrastructure\Models\Shared\Traits\HasFactory;
use Infrastructure\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Phone extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'value',
        'name',
        'description',
        'firstname',
        'lastname',
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
            related: PhoneType::class,
            foreignKey: 'phone_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            related: Country::class,
            foreignKey: 'country_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }
}
