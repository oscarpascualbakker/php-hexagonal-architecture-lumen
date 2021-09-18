<?php
declare(strict_types=1);

namespace src\User\Infrastructure\Repositories;

use src\User\Domain\Interfaces\UserRepositoryInterface;
use src\User\Domain\User;
use src\User\Domain\ValueObjects\UserName;
use src\User\Domain\ValueObjects\UserEmail;
use src\User\Domain\ValueObjects\UserPassword;


final class MemoryUserRepository implements UserRepositoryInterface
{

    private Array $repository;


    public function __construct()
    {
        $this->repository = [];
    }


    public function save(User $user): User
    {
        $data = [
            'name'     => $user->name()->value(),
            'email'    => $user->email()->value(),
            'password' => $user->password()->value(),
        ];

        $this->repository[] = $data;

        $lastInsertId = count($this->repository);

        $user->setId($lastInsertId);

        return $user;
    }


    /**
     * The IDs in an array start from 0!
     * @param Int $id
     * @return User|null
     */
    public function show(Int $id): ?User
    {
        // Adjust ID to array (starts with 0)
        $id--;
        if (array_key_exists($id, $this->repository)) {
            // This is the tricky part.  Convert into Domain User object.
            // In Doctrine this would be automatically done.  Check the following page:
            // https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/xml-mapping.html#xml-mapping
            // https://github.com/CodelyTV/php-ddd-example/blob/master/src/Backoffice/Courses/Infrastructure/Persistence/Doctrine/BackofficeCourse.orm.xml
            $user = new User(
                new UserName($this->repository[$id]['name']),
                new UserEmail($this->repository[$id]['email']),
                new UserPassword($this->repository[$id]['password'])
            );
            $id++;
            $user->setId($id);

            return $user;
        } else {
            return null;
        }
    }


    public function delete(Int $id): bool
    {
        // Adjust ID to array (starts with 0)
        $id--;

        if (array_key_exists($id, $this->repository)) {
            // 'unset' is not reindexing the array keys.  Perfect for us.
            unset($this->repository[$id]);
            return true;
        } else {
            return false;
        }
    }


    // TODO Hacer esto bien.
    public function update(User $user): Int
    {

        $user_id       = $user->id()->value();
        $user_name     = $user->name()->value();
        $user_email    = $user->email()->value();
        $user_password = $user->password()->value();

        // Adjust ID to array (starts with 0)
        $user_id--;

        if (array_key_exists($user_id, $this->repository)) {
            $this->repository[$user_id]['name'] = $user_name;
            $this->repository[$user_id]['email'] = $user_email;
            $this->repository[$user_id]['password'] = $user_password;
            return 1;   // 1 row affected.
        } else {
            return 0;
        }
    }

}
