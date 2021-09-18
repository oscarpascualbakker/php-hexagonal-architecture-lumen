<?php

namespace App\Http\Controllers;

use src\User\Infrastructure\ShowUserController as InfrastructureController;


class ShowUserController extends Controller
{

    private InfrastructureController $showUserController;


    public function __construct(InfrastructureController $showUserController)
    {
        $this->showUserController = $showUserController;
    }


    public function __invoke(Int $id)
    {
        $showUserController = $this->showUserController;
        $user               = $showUserController($id);

        if (isset($user)) {
            return response($user->toJson(), 200);
        } else {
            return response(null, 404);
        }
    }

}
