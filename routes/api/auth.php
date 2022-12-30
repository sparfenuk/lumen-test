<?php


$router->group(['namespace' => 'Api', 'prefix' => 'api/user'], function () use ($router) {
    $router->post('sign-in', 'AuthController@login');
    $router->post('register', 'AuthController@register');
    $router->post('recover-password', 'AuthController@resetPassword');
    $router->patch('recover-password', 'AuthController@resetPassword');
    //from email
    $router->get('recover-password', 'AuthController@recoverPassword');
});

