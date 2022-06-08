<?php

declare(strict_types=1);

namespace Infrastructure\Models\Establishment;

use Infrastructure\Models\Establishment\AbstractEstablishment;
use Infrastructure\Models\Profile\Profile;
use Infrastructure\Models\Shared\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class EstablishmentHasProfile extends AbstractEstablishment
{
    use HasSlug;

    /** @var string */
    protected $morphClass = 'establishment_has_profile';

    public function slugSources(): array
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
