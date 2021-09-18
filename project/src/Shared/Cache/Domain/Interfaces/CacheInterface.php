<?php

namespace src\Shared\Cache\Domain\Interfaces;


interface CacheInterface
{
    public function set(string $key, mixed $value): bool;

    public function get(string $key): mixed;

    public function delete(string $key): Int;

    public function exists(string $key): bool;
}

