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
$router->group(['prefix' => 'api'], function ($router) {
    $router ->get('listCars', 'ListCarsController@showListCars');
    $router ->get('listCars/{id}', 'ListCarsController@showCars');
    $router ->get('listUser', 'ListUserController@showListUser');
    $router ->get('listUser/{id}', 'ListUserController@showUser');
    $router ->put('listUser/{id}', 'ListUserController@update');
    $router ->put('listCars/{id}', 'ListCarsController@update');
    $router ->delete('listCars/{id}', 'ListCarsController@delete');
});
