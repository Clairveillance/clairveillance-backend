<?php

declare(strict_types=1);

namespace App\Models\Appointment;

use App\Models\Appointment\AppointmentType;
use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AppointmentWithProfile extends Model
{
    use HasUuid;
    use HasSlug;
    use HasProfile;
    use HasFactory;
    use SoftDeletes;

    public function slugSources(): array
    {
        return [
            'source' => 'name',
        ];
    }

    /** @var array<string> */
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
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
            related: AppointmentType::class,
            foreignKey: 'appointment_type_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }

    public function profile(): MorphOne
    {
        return $this->morphOne(
            related: Profile::class,
            name: 'profilable',
            type: 'profilable_type',
            id: 'profilable_uuid',
            localKey: 'uuid'
        );
    }
}
