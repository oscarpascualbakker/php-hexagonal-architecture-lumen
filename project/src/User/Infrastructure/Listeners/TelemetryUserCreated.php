<?php

namespace src\User\Infrastructure\Listeners;

use src\User\Infrastructure\Events\UserCreatedEvent;
use src\Shared\Metrics\Infrastructure\MetricsController;


final class TelemetryUserCreated
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Increase the number of created users.
     *
     * @param  src\User\Infrastructure\Events\UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $metrics = new MetricsController();
        $metrics->incCounter('create_user_total');
    }

}
