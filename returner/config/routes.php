<?php
// routes

function routes($router)
{
    $router->add('GET', '/dashboard', 'HomeController@index')->middleware('AuthMiddleware');
    // login controllers
    $router->add('get', '/login', 'LoginController@index');
    $router->add('post', '/login', 'LoginController@login');
    $router->add('post', '/logout', 'LoginController@logout')->middleware('AuthMiddleware');
    $router->add('get', '/reset-password', 'LoginController@reset_password')->middleware('AuthMiddleware');
    $router->add('post', '/reset-password', 'LoginController@reset')->middleware('AuthMiddleware');
    // admin controllers 
    $router->add('get', '/admins', 'AdminController@index');
    $router->add('post', '/admin/fetch_data', 'AdminController@fetch_data');
    $router->add('get', '/admin/create', 'AdminController@create')->middleware('AuthMiddleware');
    $router->add('post', '/admin/store', 'AdminController@store')->middleware('AuthMiddleware');
    $router->add('get', '/admin/edit', 'AdminController@edit')->middleware('AuthMiddleware');
    $router->add('post', '/admin/update', 'AdminController@update')->middleware('AuthMiddleware');
    $router->add('post', '/admin/delete', 'AdminController@delete')->middleware('AuthMiddleware');
    $router->add('post', '/admin/change_status', 'AdminController@changeStatus')->middleware('AuthMiddleware');

    // customer controllers
    $router->add('get', '/customers', 'CustomerController@index')->middleware('AuthMiddleware');
    $router->add('post', '/customers/fetch/customer_list', 'CustomerController@fetch_customer_list')->middleware('AuthMiddleware');
    $router->add('post','/change_customer_status','CustomerController@change_customer_status')->middleware('AuthMiddleware');
    $router->add('get','/user/show','CustomerController@show')->middleware('AuthMiddleware');
    // driver controllers
 $router->add('get', '/drivers', 'CustomerController@drivers')->middleware('AuthMiddleware');
    $router->add('post', '/fetch_driver_list', 'CustomerController@fetch_driver_list')->middleware('AuthMiddleware');
    $router->add('post','/change_driver_status','CustomerController@change_driver_status')->middleware('AuthMiddleware');
    $router->add('get','/driver/show','CustomerController@show_driver')->middleware('AuthMiddleware');

    // platform controllers 
    $router->add('get', '/platforms', 'PlatformController@index')->middleware('AuthMiddleware');
    $router->add('get', '/platform/create', 'PlatformController@create')->middleware('AuthMiddleware');
    $router->add('post', '/platform/store', 'PlatformController@store')->middleware('AuthMiddleware');
    $router->add('get', '/platform/edit', 'PlatformController@edit')->middleware('AuthMiddleware');
    $router->add('post', '/platform/update', 'PlatformController@update')->middleware('AuthMiddleware');
    $router->add('post', '/platform/delete', 'PlatformController@delete')->middleware('AuthMiddleware');

    // package controllers
    $router->add('get', '/packages', 'PackageController@index')->middleware('AuthMiddleware');
    $router->add('get','/package/show','PackageController@show')->middleware('AuthMiddleware');

    // subscription controllers
    $router->add('get', '/subscriptions', 'SubscriptionController@index')->middleware('AuthMiddleware');










    $router->add('get', '/404', 'LoginController@not_found');
}