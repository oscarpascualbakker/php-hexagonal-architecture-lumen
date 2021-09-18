<?php
declare(strict_types=1);

use \src\User\Domain\User;
use \src\User\Domain\ValueObjects\UserName;
use \src\User\Domain\ValueObjects\UserEmail;
use \src\User\Domain\ValueObjects\UserPassword;
use \src\User\Domain\Exceptions\InvalidEmailException;
use \src\User\Domain\Exceptions\InvalidPasswordException;
use \src\User\Infrastructure\Repositories\MemoryUserRepository;


class UserDomainTest extends TestCase
{

    protected static $repository;


    /**
     * Set the queue for all the tests.
     * The PriorityQueue is autoloaded (see composer.json).
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        static::$repository = new MemoryUserRepository;
    }


    /**
     * @covers \src\User\Domain\Exceptions\InvalidPasswordException
     * @covers \src\User\Domain\ValueObjects\UserPassword
     */
    public function test_password_exception()
    {
        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage("This password is not valid.");
        $password = new UserPassword('123456');
    }


    /**
     * @covers \src\User\Domain\Exceptions\InvalidEmailException
     * @covers \src\User\Domain\ValueObjects\UserEmail
     */
    public function test_email_exception()
    {
        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage("This email is not valid.");
        $email = new UserEmail('@mailtest.com');
    }


    /**
     * @covers \src\User\Domain\User
     * @covers \src\User\Domain\ValueObjects\UserEmail
     * @covers \src\User\Domain\ValueObjects\UserName
     * @covers \src\User\Domain\ValueObjects\UserPassword
     * @covers \src\User\Domain\ValueObjects\UserId
     */
    public function test_a_user_is_created()
    {
        $name     = new UserName('Test name');
        $email    = new UserEmail('test@mailtest.com');
        $password = new UserPassword('12345678');

        $user     = User::create($name, $email, $password);
        $response = static::$repository->save($user);

        $this->assertEquals(1, $response->id()->value());
        $this->assertEquals('Test name', $response->name()->value());
        $this->assertEquals('test@mailtest.com', $response->email()->value());
        $this->assertEquals('12345678', $response->password()->value());
    }


    /**
     * @covers \src\User\Domain\User::create
     */
    public function test_another_user_is_created()
    {
        $name     = new UserName('Test name 2');
        $email    = new UserEmail('testing@mailtest.com');
        $password = new UserPassword('abcdefgh');

        $user = User::create($name, $email, $password);
        $response = static::$repository->save($user);

        $this->assertEquals('Test name 2', $response->name()->value());
        $this->assertEquals('testing@mailtest.com', $response->email()->value());
        $this->assertEquals('abcdefgh', $response->password()->value());
    }


    /**
     * Eliminate the repository.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        static::$repository = null;
    }

}
