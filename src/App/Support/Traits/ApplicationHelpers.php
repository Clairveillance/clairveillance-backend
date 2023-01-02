<?php

declare(strict_types=1);

namespace App\Support\Traits;

trait ApplicationHelpers
{
    /**
     * Returns a string with directory separators between each segment.
     * 
     * @param  string $segments
     * @return string
     */
    public function setPath(string ...$segments): string
    {
        return join(
            separator: DIRECTORY_SEPARATOR,
            array: $segments
        );
    }
}
