<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \src\User\Infrastructure\Events\UserCreatedEvent::class => [
            \src\User\Infrastructure\Listeners\CacheUser::class,
            \src\User\Infrastructure\Listeners\EmailUserCreated::class,
            \src\User\Infrastructure\Listeners\TelemetryUserCreated::class,
        ],
        \src\User\Infrastructure\Events\UserUpdatedEvent::class => [
            \src\User\Infrastructure\Listeners\CacheUser::class,
        ],
        \src\User\Infrastructure\Events\UserDeletedEvent::class => [
            \src\User\Infrastructure\Listeners\UncacheUser::class,
        ],
    ];


    public function register() {
        parent::register();
    }

}
