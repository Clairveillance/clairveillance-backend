<?php

declare(strict_types=1);

namespace App\Redis;

use App\Redis\Contracts\RedisInterface;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis as BaseRedis;

/**
 * * Redis.
 *
 * @method static connect()
 * @method static test()
 */
final class Redis extends BaseRedis implements RedisInterface
{
    /**
     * * New Redis connection.
     *
     * @param string $name
     * @return Illuminate\Redis\Connections\
     */
    public static function connect(string $name = ''): Connection
    {
        $connection = $name != '' ? $name : config('database.redis.connection');
        $redis = BaseRedis::connection($connection);

        return $redis;
    }

    /**
     * * Test Redis connection.
     *
     * @param Illuminate\Redis\Connections\Connection $connection
     * @param string $name
     * @return array
     */
    public static function test(Connection $connection, string $name = 'redis'): array
    {
        $connection->set('test', 'Hello ' . ucfirst($name) . ' !');
        $connection->pexpire('test', (int) 5000);
        $visits = (int) $connection->incr('visits');
        $test = (string) $connection->get('test');
        $pttl_visits = $connection->pttl('visits') !== -1 ? $connection->pttl('visits') . 'ms' : 'persistant';
        $pttl_test = $connection->pttl('test') !== -1 ? $connection->pttl('test') . 'ms' : 'persistant';

        return [$visits . ' (' . $pttl_visits . ')', $test . ' (' . $pttl_test . ')'];
    }
}
