<?php

declare(strict_types=1);

namespace Infrastructure\Models\Assignment;

use Infrastructure\Models\Assignment\AbstractAssignment;
use Infrastructure\Models\Profile\Profile;
use Infrastructure\Models\Shared\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class AssignmentHasProfile extends AbstractAssignment
{
    use HasSlug;

    /** @var string */
    protected $morphClass = 'assignment_has_profile';

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
