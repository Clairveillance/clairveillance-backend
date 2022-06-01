<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface AssignableInterface
{
    public function getMorphClass(): string;
    public function assignables(): MorphToMany;
    public function assignables_has_profile(): MorphToMany;
}
