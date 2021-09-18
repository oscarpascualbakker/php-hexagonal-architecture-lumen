<?php
declare(strict_types=1);

namespace src\Shared\Cache\Infrastructure;

use src\Shared\Cache\Domain\Interfaces\CacheInterface;


final class CacheRedis implements CacheInterface
{

    public function __construct()
    {
    }


    public function set(string $key, mixed $value): bool
    {
        $value = \Opis\Closure\serialize($value);
        return app('redis')->set($key, $value);
    }


    public function get(string $key): mixed
    {
        $value = app('redis')->get($key);
        return \Opis\Closure\unserialize($value);
    }


    /**
     * @param $key
     * @return Int The number of keys deleted from the cache
     */
    public function delete(string $key): Int
    {
        return app('redis')->del($key);
    }


    public function exists(string $key): bool
    {
        return app('redis')->exists($key);
    }

}
