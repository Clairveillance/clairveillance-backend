<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasUuid;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUuid;
    use HasSlug;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'image',
        'description',
        'body'
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
        'id'
    ];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
