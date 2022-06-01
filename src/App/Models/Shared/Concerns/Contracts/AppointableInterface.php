<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface AppointableInterface
{
    public function getMorphClass(): string;
    public function appointables(): MorphToMany;
    public function appointables_has_profile(): MorphToMany;
}
