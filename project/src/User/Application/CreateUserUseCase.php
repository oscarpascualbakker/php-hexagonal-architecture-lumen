<?php
declare(strict_types=1);

namespace src\User\Application;

use Illuminate\Http\Request;
use \src\User\Domain\User;
use \src\User\Domain\Interfaces\UserRepositoryInterface;
use \src\User\Domain\ValueObjects\UserName;
use \src\User\Domain\ValueObjects\UserEmail;
use \src\User\Domain\ValueObjects\UserPassword;


final class CreateUserUseCase
{

    private UserRepositoryInterface $repository;


    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(User $user)
    {
        return $this->repository->save($user);
    }

}
