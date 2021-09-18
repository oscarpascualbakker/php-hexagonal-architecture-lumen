<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/metrics', 'MetricsController@show');


$router->group(['prefix' => 'api/v1'], function() use ($router){
    $router->post('user', 'CreateUserController');
    $router->get('user/{id}', 'ShowUserController');
    $router->delete('user/{id}', 'DeleteUserController');
    $router->put('user', 'UpdateUserController');
});
