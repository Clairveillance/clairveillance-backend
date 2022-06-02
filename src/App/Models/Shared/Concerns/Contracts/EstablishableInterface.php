<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface EstablishableInterface
{
    public function getMorphClass(): string;

    public function establishables(): MorphToMany;

    public function establishables_has_profile(): MorphToMany;
}
