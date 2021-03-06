<?php

declare(strict_types=1);

namespace Infrastructure\Redis\Contracts;

use Illuminate\Redis\Connections\Connection;

interface RedisInterface
{
    public static function connect(string $name): Connection;
}
