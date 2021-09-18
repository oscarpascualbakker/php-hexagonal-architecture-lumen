<?php

namespace src\User\Domain\Interfaces;

use src\User\Domain\User;


interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function show(Int $id): ?User;

    public function delete(Int $id): bool;

    public function update(User $user): Int;
}

