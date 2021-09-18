<?php
declare(strict_types=1);

namespace src\User\Domain\ValueObjects;


use \src\User\Domain\Exceptions\InvalidPasswordException;


final class UserPassword
{
    private string $value;

    public function __construct(string $password)
    {
        $this->validate($password);
        $this->value = $password;
    }


    public function validate(string $password): void
    {
        // Only one short validation here.
        if (strlen($password) < 8) {
            throw new InvalidPasswordException();
        }
    }


    public function value(): string
    {
        return $this->value;
    }

}
