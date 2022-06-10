<?php

declare(strict_types=1);

namespace App\Support\Traits;

use Illuminate\Support\Carbon;

trait FormatDates
{
    /**
     * Returns a datetime to string.
     * 
     * @param  \Illuminate\Support\Carbon|string|null $date
     * @param  string|null $format
     * @return string|null
     */
    public static function dateTimeToString(Carbon|string|null $date, string $format = 'Y-m-d H:i:s'): ?string
    {
        return
            null === $date ? $date :
            date(
                (string) $format,
                strtotime((string) $date)
            );
    }
}
