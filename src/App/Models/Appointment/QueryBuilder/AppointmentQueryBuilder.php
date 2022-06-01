<?php

declare(strict_types=1);

namespace App\Models\Appointment\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

final class AppointmentQueryBuilder extends Builder
{
    public function published(bool $value = true): self
    {
        return $this->where('published', $value);
    }

    public function unpublished(bool $value = true): self
    {
        $value = $value !== true ?: false;
        return $this->where('published', $value);
    }
}
