<?php

namespace src\User\Infrastructure\Events;

use src\User\Domain\User;
use \App\Events\Event;


class UserDeletedEvent extends Event
{
//    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $key;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

}
