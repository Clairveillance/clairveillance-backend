<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Shared\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shared\Concerns\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssemblyType extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    /** @var array<string> */
    protected $fillable = [
        'name'
    ];

    /** @var array<string> */
    protected $hidden = [
        'id'
    ];

    /** @var array<string,string> */
    protected $casts = [
        //
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function assemblies(): HasMany
    {
        return $this->hasMany(Assembly::class, 'assembly_type_uuid', 'uuid');
    }
}
