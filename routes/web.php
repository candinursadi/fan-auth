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

$router->post('/login', ['uses' => 'AuthController@login', "as" => 'login']);

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->post('/presence', ['uses' => 'UserController@checkInOut', "as" => 'check-in-out']);
    $router->get('/user', ['uses' => 'UserController@getUser', "as" => 'get-user']);
});
