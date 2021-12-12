<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\Concerns\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Assignment extends Model
{
    use HasUuid;
    use HasSlug;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'title',
        'description',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
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
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AssignmentType::class, 'assignment_type_uuid', 'uuid');
    }

    public function assemblies(): MorphToMany
    {
        return $this->MorphToMany(Assembly::class, 'assemblable', null, 'assembly_uuid', 'assemblable_uuid', 'uuid', 'uuid');
    }
}
