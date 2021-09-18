<?php
declare(strict_types=1);

namespace src\User\Domain\ValueObjects;

use \src\User\Domain\Exceptions\InvalidEmailException;


final class UserEmail
{

    private string $value;


    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }


    public function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
    }


    public function value(): string
    {
        return $this->value;
    }

}
