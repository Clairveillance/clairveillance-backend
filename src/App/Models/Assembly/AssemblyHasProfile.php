<?php

declare(strict_types=1);

namespace App\Models\Assembly;

use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class AssemblyHasProfile extends AbstractAssembly
{
    use HasSlug;
    // use HasProfile;

    /** @var string */
    protected $morphClass = 'assembly_has_profile';

    protected function slugSources(): array
    {
        return [
            'source' => 'name',
        ];
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
