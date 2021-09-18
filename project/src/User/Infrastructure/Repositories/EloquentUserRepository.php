<?php
declare(strict_types=1);

namespace src\User\Infrastructure\Repositories;

use App\Models\User as EloquentUserModel;
use src\User\Domain\Interfaces\UserRepositoryInterface;
use src\User\Domain\User;
use src\User\Domain\ValueObjects\UserName;
use src\User\Domain\ValueObjects\UserEmail;
use src\User\Domain\ValueObjects\UserPassword;


final class EloquentUserRepository implements UserRepositoryInterface
{

    private EloquentUserModel $eloquentUserModel;


    public function __construct()
    {
        $this->eloquentUserModel = new EloquentUserModel;
    }


    public function save(User $user): User
    {
        $newUser = $this->eloquentUserModel;

        $data = [
            'name'     => $user->name()->value(),
            'email'    => $user->email()->value(),
            'password' => $user->password()->value(),
        ];

        $lastInsertId = $newUser->create($data)->id;

        $user->setId($lastInsertId);

        return $user;
    }


    public function show(Int $id): ?User
    {
        $eloquentUser = $this->eloquentUserModel->find($id);

        if ($eloquentUser) {
            // This is the tricky part.  Convert into Domain User object.
            // In Doctrine this would be automatically done.  Check the following page:
            // https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/xml-mapping.html#xml-mapping
            // https://github.com/CodelyTV/php-ddd-example/blob/master/src/Backoffice/Courses/Infrastructure/Persistence/Doctrine/BackofficeCourse.orm.xml
            $user = new User(
                new UserName($eloquentUser->getAttribute('name')),
                new UserEmail($eloquentUser->getAttribute('email')),
                new UserPassword($eloquentUser->getAttribute('password'))
            );
            $user->setId($eloquentUser->getAttribute('id'));

            return $user;
        } else {
            return null;
        }
    }


    public function delete(Int $id): bool
    {
        try {
            return $this->eloquentUserModel->find($id)->delete();
        } catch(\Throwable $e) {
            return false;
        }

    }


    public function update(User $user): Int
    {
        $user_id       = $user->id()->value();
        $user_name     = $user->name()->value();
        $user_email    = $user->email()->value();
        $user_password = $user->password()->value();

        return $this->eloquentUserModel->where('id', $user_id)->update(['name' => $user_name, 'email' => $user_email, 'password' => $user_password]);
    }

}
