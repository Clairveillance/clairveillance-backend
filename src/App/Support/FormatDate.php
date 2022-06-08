<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Carbon;

final class FormatDate
{
    public static function humanizeYmdHis(Carbon|string|null $date): ?string
    {
        return
            null === $date ? $date :
            date(
                (string) 'Y-m-d H:i:s',
                strtotime((string) $date)
            );
    }
}
