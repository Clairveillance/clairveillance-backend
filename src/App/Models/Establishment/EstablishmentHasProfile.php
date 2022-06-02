<?php

declare(strict_types=1);

namespace App\Models\Establishment;

use App\Models\Establishment\AbstractEstablishment;
use App\Models\Profile\Profile;
use App\Models\Shared\Concerns\Traits\HasSlug;
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
