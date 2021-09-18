<?php
declare(strict_types=1);

namespace src\User\Domain\Exceptions;

use Exception;


class InvalidEmailException extends Exception
{

    public function __construct()
    {
        $message = "This email is not valid.";
        $code    = 400;

        parent::__construct($message, $code);
    }

}