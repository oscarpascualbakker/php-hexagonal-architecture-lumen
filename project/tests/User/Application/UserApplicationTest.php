<?php
declare(strict_types=1);

use \src\User\Domain\User;
use \src\User\Domain\ValueObjects\UserName;
use \src\User\Domain\ValueObjects\UserEmail;
use \src\User\Domain\ValueObjects\UserPassword;
use \src\User\Domain\Exceptions\InvalidPasswordException;
use \src\User\Infrastructure\Repositories\MemoryUserRepository;
use \src\User\Application\CreateUserUseCase;
use \src\User\Application\ShowUserUseCase;
use \src\User\Application\DeleteUserUseCase;
use \src\User\Application\UpdateUserUseCase;


class UserApplicationTest extends TestCase
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
     * @covers \src\User\Application\CreateUserUseCase
     */
    public function test_creation_from_application_layer()
    {
        $createUserUseCase = new CreateUserUseCase(static::$repository);
        $response = $createUserUseCase(
            new User(
                new UserName('Pepe'),
                new UserEmail('pepe@fakemail.com'),
                new UserPassword('12345678')
            )
        );
        $this->assertEquals('Pepe', $response->name()->value());
        $this->assertEquals('pepe@fakemail.com', $response->email()->value());
        $this->assertEquals('12345678', $response->password()->value());

    }


    /**
     * @covers \src\User\Application\CreateUserUseCase
     */
    public function test_creation_from_application_layer_fails()
    {
        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage("This password is not valid.");

        $createUserUseCase = new CreateUserUseCase(static::$repository);
        $createUserUseCase(
            new User(
                new UserName('Pepe'),
                new UserEmail('pepe@fakemail.com'),
                new UserPassword('1234')
            )
        );
    }


    /**
     * @covers \src\User\Application\ShowUserUseCase
     * @return User
     */
    public function test_a_user_is_found_from_application_layer(): User
    {
        $showUserUseCase = new ShowUserUseCase(static::$repository);
        $response        = $showUserUseCase(1);
        $this->assertEquals('Pepe', $response->name()->value());
        $this->assertEquals('pepe@fakemail.com', $response->email()->value());
        $this->assertEquals('12345678', $response->password()->value());

        return $response;
    }


    /**
     * @depends test_a_user_is_found_from_application_layer
     * @covers \src\User\Application\UpdateUserUseCase
     * @covers \src\User\Domain\User::setName
     */
    public function test_a_user_is_updated_from_application_layer(User $previous_response)
    {
        // First, set new name to the previous response
        $previous_response->setName('Pepe2');

        // Update the user and check the affected rows is 1 (and only 1)
        $updateUserUseCase = new UpdateUserUseCase(static::$repository);
        $affected_rows     = $updateUserUseCase($previous_response);
        $this->assertEquals(1, $affected_rows);

        // Finally, get again the user and check name change
        $showUserUseCase = new ShowUserUseCase(static::$repository);
        $response        = $showUserUseCase(1);

        $this->assertEquals('Pepe2', $response->name()->value());
    }


    /**
     * @covers \src\User\Application\DeleteUserUseCase
     */
    public function test_a_user_is_deleted_from_application_layer()
    {
        $deleteUserUseCase = new DeleteUserUseCase(static::$repository);
        $response          = $deleteUserUseCase(1);
        $this->assertTrue($response);
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
