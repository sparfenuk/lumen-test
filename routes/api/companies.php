<?php

$router->group(['namespace' => 'Api', 'prefix' => 'api/user', 'middleware' => 'auth'], function () use ($router) {
    $router->get('companies', 'UserController@getCompanies');
    $router->post('companies', 'CompanyController@createCompany');
});

