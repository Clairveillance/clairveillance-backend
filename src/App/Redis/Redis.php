<?php

declare(strict_types=1);

namespace App\Redis;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis as BaseRedis;
use App\Redis\Contracts\RedisInterface;

/**
 * * Redis.
 *
 * @method static \App\Redis\Redis\connect()
 */
final class Redis extends BaseRedis implements RedisInterface
{
    /**
     * * New Redis connection.
     *
     * @param string $name
     * @return Connection
     */
    public static function connect(string $name = ''): Connection
    {
        $connection = $name != '' ? $name : config('database.redis.connection');
        $redis = BaseRedis::connection($connection);

        return $redis;
    }
}
