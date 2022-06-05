<?php

declare(strict_types=1);

namespace App\Core\Resources\Api\V1\Shared\Traits;

use Illuminate\Support\Carbon;

trait HasFilters
{
    public function getFormattedDate(Carbon|string|null $date): string|null
    {
        return
            null === $date ? $date :
            date(
                (string) 'Y-m-d H:i:s',
                strtotime((string) $date)
            );
    }
}
