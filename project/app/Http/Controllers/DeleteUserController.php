<?php

namespace App\Http\Controllers;

use src\User\Infrastructure\DeleteUserController as InfrastructureController;


class DeleteUserController extends Controller
{

    private InfrastructureController $deleteUserController;


    public function __construct(InfrastructureController $deleteUserController)
    {
        $this->deleteUserController = $deleteUserController;
    }


    public function __invoke(Int $id)
    {
        $deleteUserController = $this->deleteUserController;

        if ($deleteUserController($id)) {
            return response(null, 200);
        } else {
            return response(null, 404);
        }
    }

}
