<?php
declare(strict_types=1);

namespace src\User\Infrastructure;

use Illuminate\Http\Request;
use src\User\Infrastructure\Events\UserUpdatedEvent;
use src\User\Domain\User;
use src\User\Application\UpdateUserUseCase;
use src\User\Domain\ValueObjects\UserEmail;
use src\User\Domain\ValueObjects\UserName;
use src\User\Domain\ValueObjects\UserPassword;
use src\Shared\Cache\Domain\Interfaces\CacheInterface;


final class UpdateUserController
{

    private UpdateUserUseCase $updateUserUseCase;
    private CacheInterface $cache;


    public function __construct(UpdateUserUseCase $updateUserUseCase, CacheInterface $cache)
    {
        $this->updateUserUseCase = $updateUserUseCase;
        $this->cache             = $cache;
    }


    public function __invoke(Request $request): Int
    {
        $id       = intval($request->input('id'));
        $name     = new UserName($request->input('name'));
        $email    = new UserEmail($request->input('email'));
        $password = new UserPassword($request->input('password'));

        $user = User::create($name, $email, $password);
        $user->setId($id);

        $updateUserUseCase = $this->updateUserUseCase;
        $affectedRows      = $updateUserUseCase($user);

        // Once the user is updated, we fire the "UserUpdated" event.
        if ($affectedRows > 0) {
            event(new UserUpdatedEvent($user));
        }
        return $affectedRows;
    }


}
