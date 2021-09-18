<?php
declare(strict_types=1);

namespace src\User\Domain;

use src\User\Domain\ValueObjects\UserId;
use src\User\Domain\ValueObjects\UserName;
use src\User\Domain\ValueObjects\UserEmail;
use src\User\Domain\ValueObjects\UserPassword;


final class User
{

    private $id;
    private $name;
    private $email;
    private $password;


    public function __construct(UserName $name, UserEmail $email, UserPassword $password)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }


    public static function create(UserName $name, UserEmail $email, UserPassword $password): User
    {
        return new self($name, $email, $password);
    }


    public function id(): UserId
    {
        return $this->id;
    }


    public function name(): UserName
    {
        return $this->name;
    }


    public function email(): UserEmail
    {
        return $this->email;
    }


    public function password(): UserPassword
    {
        return $this->password;
    }


    public function setId($id)
    {
        $this->id = new UserId($id);
    }


    public function setName($name)
    {
        $this->name = new UserName($name);
    }


    /**
     *This
     */
    public function toJson(): String
    {
        $array['id'] = $this->id()->value();
        $array['name'] = $this->name()->value();
        $array['email'] = $this->email()->value();
        $array['password'] = $this->password()->value();

        return json_encode($array);

        // This is how Codely resolves the problem (and I love it).
        // This response should be created in the Infrastructure layer.
        // https://github.com/CodelyTV/php-ddd-example/blob/master/apps/backoffice/backend/src/Controller/Courses/CoursesGetController.php
    }

}
