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
     * @return Connection
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
     * @param Illuminate\Redis\Connections\Connection $redis
     * @param string $name
     * @return array
     */
    public static function test(Connection $redis, string $name = 'redis'): array
    {
        $redis->set('test', 'Hello ' . ucfirst($name) . ' !');
        $redis->pexpire('test', (int) 5000);
        $visits = (int) $redis->incr('visits');
        $test = (string) $redis->get('test');
        $pttl_visits = $redis->pttl('visits') !== -1 ? $redis->pttl('visits') . 'ms' : 'persistant';
        $pttl_test = $redis->pttl('test') !== -1 ? $redis->pttl('test') . 'ms' : 'persistant';
        return [$visits . ' (' . $pttl_visits . ')', $test . ' (' . $pttl_test . ')'];
    }
}
