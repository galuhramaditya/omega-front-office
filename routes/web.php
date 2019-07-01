<?php

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

// view
$router->group(["name" => "view"], function () use ($router) {
    $router->get('/', 'ViewController@index');
    $router->get('/login', 'ViewController@login');
});


// api
$router->group(["prefix" => "user"], function () use ($router) {
    $router->post('/login', 'UserController@login');
    $router->group(["middleware" => "authToken"], function () use ($router) {
        $router->post('/current', 'UserController@current');
    });
});

$router->group(["prefix" => "outlet"], function () use ($router) {
    $router->get("/get", "OutletController@get");
});

$router->group(["prefix" => "report"], function () use ($router) {
    $router->group(["prefix" => "day-of-week-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@dayOfWeekGuestAnalysis');
        $router->post('/', 'ReportController@dayOfWeekGuestAnalysis');
    });
    $router->group(["prefix" => "monthly-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@monthlyGuestAnalysis');
        $router->post('/', 'ReportController@monthlyGuestAnalysis');
    });
    $router->group(["prefix" => "weekly-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@weeklyGuestAnalysis');
        $router->post('/', 'ReportController@weeklyGuestAnalysis');
    });
});

// $router->group(['middleware' => 'adminAccess'], function () use ($router) {
//     $router->get('/admin/account', 'AdminController@account');
//     $router->post('/user/register', 'UserController@register');
//     $router->patch('/user/update', 'UserController@update');
//     $router->patch('/user/changePassword', 'UserController@changePassword');
//     $router->delete('/user/delete', ['middleware' => 'authPassword', 'uses' => 'UserController@delete']);
// });