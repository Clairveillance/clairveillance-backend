<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasProfile;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Establishment extends Model
{
    use HasUuid;
    use HasSlug;
    use HasProfile;
    use HasFactory;
    use SoftDeletes;

    public function slugSource(): array
    {
        return [
            'source' => 'title',
        ];
    }

    /** @var array<string> */
    protected $fillable = [
        'title',
        'description',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
        'establishment_type_uuid',
    ];

    /** @var array<string,string> */
    protected $casts = [
        //
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
            related: EstablishmentType::class,
            foreignKey: 'establishment_type_uuid',
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

    public function assemblies(): MorphToMany
    {
        return $this->morphToMany(
            related: Assembly::class,
            name: 'assemblable',
            table: null,
            foreignPivotKey: 'assembly_uuid',
            relatedPivotKey: 'assemblable_uuid',
            parentKey: 'uuid',
            relatedKey: 'uuid',
            inverse: false
        );
    }
}
