<?php

declare(strict_types=1);

namespace App\Models\Email;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EmailType extends Model
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

    public function emails(): HasMany
    {
        return $this->hasMany(
            related: Email::class,
            foreignKey: 'email_type_uuid',
            localKey: 'uuid'
        );
    }
}
