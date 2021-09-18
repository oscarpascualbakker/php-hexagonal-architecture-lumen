<?php
declare(strict_types=1);

namespace src\User\Domain\ValueObjects;


final class UserName
{

    private string $value;


    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = $name;
    }


    public function validate(string $name): void
    {
    }


    public function value(): string
    {
        return $this->value;
    }

}
