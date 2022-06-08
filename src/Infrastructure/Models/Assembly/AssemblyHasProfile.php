<?php

declare(strict_types=1);

namespace Infrastructure\Models\Assembly;

use Infrastructure\Models\Assembly\AbstractAssembly;
use Infrastructure\Models\Profile\Profile;
use Infrastructure\Models\Shared\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class AssemblyHasProfile extends AbstractAssembly
{
    use HasSlug;

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
