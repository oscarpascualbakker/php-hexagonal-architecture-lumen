<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use src\User\Infrastructure\CreateUserController as InfrastructureController;


class CreateUserController extends Controller
{

    private InfrastructureController $createUserController;


    public function __construct(InfrastructureController $createUserController)
    {
        $this->createUserController = $createUserController;
    }


    public function __invoke(Request $request)
    {
        $createUserController = $this->createUserController;
        $user = $createUserController($request);

        if (isset($user)) {
            return response($user->toJson(), 200);
        } else {
            return response(null, 400);
        }
    }

}
