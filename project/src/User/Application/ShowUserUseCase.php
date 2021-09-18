<?php
declare(strict_types=1);

namespace src\User\Application;

use \src\User\Domain\Interfaces\UserRepositoryInterface;


final class ShowUserUseCase
{

    private UserRepositoryInterface $repository;


    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(int $id)
    {
        return $this->repository->show($id);

        // This is how Codely resolves the problem (and I love it).
        // This response should be created in the Infrastructure layer.
        // https://github.com/CodelyTV/php-ddd-example/blob/master/apps/backoffice/backend/src/Controller/Courses/CoursesGetController.php
    }

}
