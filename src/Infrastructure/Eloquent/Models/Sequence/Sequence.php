<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Sequence;

use Infrastructure\Eloquent\Models\Shared\Traits\HasFactory;
use Infrastructure\Eloquent\Models\Shared\Traits\HasUuid;
use Infrastructure\Eloquent\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sequence extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
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
            related: SequenceType::class,
            foreignKey: 'sequence_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }
}
