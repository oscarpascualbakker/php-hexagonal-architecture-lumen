<?php
declare(strict_types=1);

namespace src\User\Infrastructure;

use src\User\Infrastructure\Events\UserCreatedEvent;
use Illuminate\Http\Request;

use src\User\Domain\User;
use src\User\Domain\ValueObjects\UserEmail;
use src\User\Domain\ValueObjects\UserName;
use src\User\Domain\ValueObjects\UserPassword;
use src\User\Application\CreateUserUseCase;


final class CreateUserController
{

    private CreateUserUseCase $createUserUseCase;


    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }


    public function __invoke(Request $request): ?User
    {
        $name     = new UserName($request->input('name'));
        $email    = new UserEmail($request->input('email'));
        $password = new UserPassword($request->input('password'));

        $user = User::create($name, $email, $password);

        $createUserUseCase = $this->createUserUseCase;
        $user              = $createUserUseCase($user);

        // Once the user is created, we fire the "UserCreated" event.
        event(new UserCreatedEvent($user));

        return $user;
    }

}
