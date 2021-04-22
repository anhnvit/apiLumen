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
$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@signIn');
$router->post('forget-password', 'AuthController@forgetPassword');
$router->post('sen-otp', 'AuthController@sendOtp');
$router->group(['prefix' => 'api','middleware' => 'auth'], function () use ($router) {
    $router->get('get-list-user', 'AuthController@getListUser');
    $router->get('userInfo', 'AuthController@getUserProfile');
    $router->get('getUserInfo', 'AuthController@getUserProfile');
    $router->patch('changePassword', 'AuthController@changePassword');
});
