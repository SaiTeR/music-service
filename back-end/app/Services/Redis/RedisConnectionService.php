<?php

namespace App\Services\Redis;

use Predis\Client;

class RedisConnectionService
{
    private static ?Client $redisClient = null;

    public static function makeConnection(): Client
    {
        if (self::$redisClient === null) {
            self::$redisClient = new Client([
                'scheme' => "tcp",
                'host'   => "redis.music.local",
                'port'   => "6379",
                'read_write_timeout' => -1
            ]);
        }
        return self::$redisClient;
    }
}
