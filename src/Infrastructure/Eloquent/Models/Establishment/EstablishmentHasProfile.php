<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Establishment;

use Infrastructure\Eloquent\Models\Establishment\AbstractEstablishment;
use Infrastructure\Eloquent\Models\Profile\Profile;
use Infrastructure\Eloquent\Models\Shared\Traits\HasSlug;
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
