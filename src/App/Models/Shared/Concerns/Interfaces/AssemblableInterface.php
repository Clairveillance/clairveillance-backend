<?php

declare(strict_types=1);

namespace App\Models\Shared\Concerns\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface AssemblableInterface
{
    public function getMorphClass(): string;
    public function assemblables(): MorphToMany;
    public function assemblables_has_profile(): MorphToMany;
}
