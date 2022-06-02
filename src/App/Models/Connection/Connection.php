<?php

declare(strict_types=1);

namespace App\Models\Connection;

use App\Models\Shared\Traits\HasFactory;
use App\Models\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Connection extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'ip', //NOTE $_SERVER[‘REMOTE_ADDR’]
        'browser', //NOTE $_SERVER[‘HTTP_USER_AGENT’]
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
            related: ConnectionType::class,
            foreignKey: 'connection_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }
}
