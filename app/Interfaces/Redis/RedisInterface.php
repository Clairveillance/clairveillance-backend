<?php

declare(strict_types=1);

namespace App\Interfaces\Redis;

use Illuminate\Redis\Connections\Connection;

interface RedisInterface
{
    public static function connect(string $name): Connection;
}
