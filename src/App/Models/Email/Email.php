<?php

declare(strict_types=1);

namespace App\Models\Email;

use App\Models\Shared\Concerns\Traits\HasFactory;
use App\Models\Shared\Concerns\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Email extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'value',
        'name',
        'description',
        'host',
        'domain',
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
            related: EmailType::class,
            foreignKey: 'email_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }
}
