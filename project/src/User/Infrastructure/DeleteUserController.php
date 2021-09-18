<?php
declare(strict_types=1);

namespace src\User\Infrastructure;

use src\User\Infrastructure\Events\UserDeletedEvent;
use src\User\Application\DeleteUserUseCase;
use src\Shared\Cache\Domain\Interfaces\CacheInterface;


final class DeleteUserController
{

    private DeleteUserUseCase $deleteUserUseCase;
    private CacheInterface $cache;


    public function __construct(DeleteUserUseCase $deleteUserUseCase, CacheInterface $cache)
    {
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->cache             = $cache;
    }


    public function __invoke(Int $id): bool
    {
        // Once the user is updated, we fire the "UserCreatedOrUpdated" event.
        $key = 'user_' . $id;
        event(new UserDeletedEvent($key));

        $deleteUserUseCase = $this->deleteUserUseCase;
        return $deleteUserUseCase($id);
    }

}
