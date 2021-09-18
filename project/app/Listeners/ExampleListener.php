<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use \App\Events\UserCreatedOrUpdatedEvent;


class ExampleListener
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
     * @param  \App\Events\UserCreatedOrUpdatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedOrUpdatedEvent $event)
    {
        //
    }
}
