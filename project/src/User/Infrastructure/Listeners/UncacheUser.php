<?php

namespace src\User\Infrastructure\Listeners;

use src\User\Infrastructure\Events\UserDeletedEvent;
use Illuminate\Support\Facades\Log;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use src\Shared\Cache\Domain\Interfaces\CacheInterface;


final class UncacheUser
{

    private CacheInterface $cache;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }


    /**
     * Save user to cache.
     *
     * @param  src\User\Infrastructure\Events\UserDeletedEvent $event
     * @return void
     */
    public function handle(UserDeletedEvent $event)
    {
        $key = $event->key;
        $this->cache->delete($key);
    }

}
