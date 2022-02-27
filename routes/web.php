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

$router->post('register', 'AuthenticationController@register');
$router->post('login', 'AuthenticationController@login');

$router->post('send-otp', 'AuthenticationController@sendOtp');
$router->post('reset-password', 'AuthenticationController@resetPassword');

$router->group(['middleware' => ['auth']], function ($router) {
    $router->group(['prefix' => 'products'], function ($router) {
        $router->get('/', 'ProductController@getProductListing');
        $router->get('{id}', 'ProductController@getProductDetails');
    });

    $router->group(['prefix' => 'cart'], function ($router) {
        $router->get('/', 'CartController@getCartListing');
        $router->post('{id}', 'CartController@store');
    });

    $router->get('profile', 'ProfileController@getProfileDetails');
    $router->post('profile', 'ProfileController@updateProfileDetails');
});
