<?php

namespace src\User\Infrastructure\Events;

use src\User\Domain\User;
use \App\Events\Event;


// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;


final class UserCreatedEvent extends Event
{

    // use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        // This is sent to the listener
        $this->user = $user;
    }

}
