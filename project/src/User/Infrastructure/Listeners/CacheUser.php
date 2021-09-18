<?php

namespace src\User\Infrastructure\Listeners;

use src\User\Infrastructure\Events\UserCreatedEvent;
use src\User\Infrastructure\Events\UserUpdatedEvent;
use src\Shared\Cache\Domain\Interfaces\CacheInterface;
// use http\Exception\InvalidArgumentException;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Bus\Queueable;
// use Illuminate\Queue\SerializesModels;


final class CacheUser
{

    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * @param  src\User\Infrastructure\Events\UserCreatedOrUpdatedEvent $event
     * @return void
     */
    public function handle($event)
    {
        $key   = 'user_'.$event->user->id()->value();
        $value = $event->user;

        $this->cache->set($key, $value);
    }

}
