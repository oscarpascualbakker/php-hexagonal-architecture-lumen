<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use src\User\Infrastructure\UpdateUserController as InfrastructureController;


class UpdateUserController extends Controller
{

    private InfrastructureController $updateUserController;


    public function __construct(InfrastructureController $updateUserController)
    {
        $this->updateUserController = $updateUserController;
    }


    public function __invoke(Request $request)
    {
        $updateUserController = $this->updateUserController;
        return $updateUserController($request);
    }

}
