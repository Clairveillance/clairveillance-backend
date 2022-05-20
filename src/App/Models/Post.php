<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Shared\Concerns\HasFactory;
use App\Models\Shared\Concerns\HasSlug;
use App\Models\Shared\Concerns\HasUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasUuid;
    use HasSlug;
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
        'image',
        'description',
        'body',
    ];

    /** @var array<string> */
    protected $hidden = [
        'id',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'author_uuid',
            ownerKey: 'uuid',
            relation: null
        );
    }
}
