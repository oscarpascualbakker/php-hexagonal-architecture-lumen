<?php
declare(strict_types=1);

namespace src\User\Domain\ValueObjects;


final class UserId
{

    private int $value;


    public function __construct(int $id)
    {
        $this->validate($id);
        $this->value = $id;
    }


    public function validate(int $id): void
    {
    }


    public function value(): int
    {
        return $this->value;
    }

}
