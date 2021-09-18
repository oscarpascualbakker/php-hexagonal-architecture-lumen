<?php

namespace src\User\Infrastructure\Listeners;

use src\User\Infrastructure\Events\UserCreatedEvent;
use Illuminate\Support\Facades\Log;


final class EmailUserCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  src\User\Infrastructure\Events\UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        // Send the customer a welcome email (instead of that we just write a log message...)
        Log::info('I have sent an email to the new user with ID ' . $event->user->id()->value() . '.');
    }

}
