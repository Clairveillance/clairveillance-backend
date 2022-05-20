<?php

declare(strict_types=1);

namespace App\Models\Address;

use App\Models\Country\Country;
use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Address extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name',
        'description',
        'firstname',
        'lastname',
        'street_1',
        'street_2',
        'street_number',
        'apartment',
        'city',
        'post_code',
        'region',
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
            related: AddressType::class,
            foreignKey: 'address_type_uuid',
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
