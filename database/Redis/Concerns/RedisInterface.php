<?php

declare(strict_types=1);

namespace Database\Redis\Concerns;

use Illuminate\Redis\Connections\Connection;

interface RedisInterface
{
    public static function connect(string $name): Connection;
}
