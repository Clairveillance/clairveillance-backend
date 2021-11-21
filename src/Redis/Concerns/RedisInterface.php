<?php

declare(strict_types=1);

namespace Redis\Concerns;

use Illuminate\Redis\Connections\Connection;

interface RedisInterface
{
    public static function connect(string $name): Connection;
}
