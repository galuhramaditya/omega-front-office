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

// outlet
$router->group(["prefix" => "outlet"], function () use ($router) {
    $router->get("/get", "OutletController@get");
});

// company
$router->group(["prefix" => "company"], function () use ($router) {
    $router->get("/get", "CompanyController@get");
});

// report
$router->group(["prefix" => "report"], function () use ($router) {
    $router->group(["prefix" => "day-of-week-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@dayOfWeekGuestAnalysis');
        $router->post('/', 'ReportController@dayOfWeekGuestAnalysis');
    });

    $router->group(["prefix" => "weekly-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@weeklyGuestAnalysis');
        $router->post('/', 'ReportController@weeklyGuestAnalysis');
    });

    $router->group(["prefix" => "monthly-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@monthlyGuestAnalysis');
        $router->post('/', 'ReportController@monthlyGuestAnalysis');
    });

    $router->group(["prefix" => "yearly-guest-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@yearlyGuestAnalysis');
        $router->post('/', 'ReportController@yearlyGuestAnalysis');
    });

    $router->group(["prefix" => "player-in-house"], function () use ($router) {
        $router->get('/', 'ViewController@playerInHouse');
        $router->post('/', 'ReportController@playerInHouse');
    });

    $router->group(["prefix" => "player-in-house"], function () use ($router) {
        $router->get('/', 'ViewController@playerInHouse');
        $router->post('/', 'ReportController@playerInHouse');
    });

    $router->group(["prefix" => "balance-sheet"], function () use ($router) {
        $router->get('/', 'ViewController@balanceSheet');
        $router->post('/', 'ReportController@balanceSheet');
    });
});

// user
$router->group(["prefix" => "user"], function () use ($router) {
    $router->post('/login', 'UserController@login');

    $router->group(["middleware" => "authToken"], function () use ($router) {
        $router->post('/current', 'UserController@current');

        $router->group(["middleware" => "authAdmin"], function () use ($router) {
            $router->post('/create', 'UserController@create');
            $router->patch('/edit', 'UserController@edit');
            $router->group(["middleware" => "authPassword"], function () use ($router) {
                $router->delete('/delete', 'UserController@delete');
            });
        });

        $router->group(["prefix" => "self-edit"], function () use ($router) {
            $router->patch('/', 'UserController@selfEdit');
            $router->group(["middleware" => "authPassword"], function () use ($router) {
                $router->patch('/change-password', 'UserController@changeSelfPassword');
            });
        });
    });

    $router->group(["prefix" => "account"], function () use ($router) {
        $router->get('/', 'ViewController@account');
        $router->get('/get', 'UserController@get');
    });
});