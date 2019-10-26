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
    $router->get('/', 'ViewController@dashboard');
    $router->get('/login', 'ViewController@login');
});

// outlet
$router->group(["prefix" => "outlet"], function () use ($router) {
    $router->get("/get", "OutletController@get");
});

// role
$router->group(["prefix" => "role"], function () use ($router) {
    $router->get("/", "ViewController@roles");
    $router->group(["middleware" => "authToken"], function () use ($router) {
        $router->get("/get", "RoleController@get");
        $router->post("/create", "RoleController@create");
        $router->patch("/edit", "RoleController@edit");
        $router->group(["middleware" => "authPassword"], function () use ($router) {
            $router->delete("/delete", "RoleController@delete");
        });
    });
});

// page
$router->group(["prefix" => "page"], function () use ($router) {
    $router->get("/", "ViewController@pages");
    $router->group(["middleware" => "authToken"], function () use ($router) {
        $router->get("/get", "PageController@get");
        $router->post("/create", "PageController@create");
        $router->patch("/edit", "PageController@edit");
        $router->group(["middleware" => "authPassword"], function () use ($router) {
            $router->delete("/delete", "PageController@delete");
        });
    });
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

    $router->group(["prefix" => "outlet-revenue-analysis"], function () use ($router) {
        $router->get('/', 'ViewController@outletRevenueAnalysis');
        $router->post('/', 'ReportController@outletRevenueAnalysis');
    });

    $router->group(["prefix" => "fb-top-sales"], function () use ($router) {
        $router->get('/', 'ViewController@fbTopSales');
        $router->post('/', 'ReportController@fbTopSales');
    });

    $router->group(["prefix" => "ytd-top-sales"], function () use ($router) {
        $router->get('/', 'ViewController@ytdTopSales');
        $router->post('/', 'ReportController@ytdTopSales');
    });
});

// user
$router->group(["prefix" => "user"], function () use ($router) {
    $router->post('/login', 'UserController@login');
    $router->get('/profile', 'ViewController@profile');

    $router->group(["prefix" => "accounts"], function () use ($router) {
        $router->get('/', 'ViewController@accounts');
        $router->group(["middleware" => "authToken"], function () use ($router) {
            $router->get('/get', 'UserController@get');
        });
    });

    $router->group(["middleware" => "authToken"], function () use ($router) {
        $router->post('/current', 'UserController@current');
        $router->post('/create', 'UserController@create');
        $router->patch('/edit', 'UserController@edit');

        $router->group(["middleware" => "authPassword"], function () use ($router) {
            $router->delete('/delete', 'UserController@delete');
        });

        $router->group(["prefix" => "self-edit"], function () use ($router) {
            $router->patch('/', 'UserController@selfEdit');
            $router->group(["middleware" => "authPassword"], function () use ($router) {
                $router->patch('/change-password', 'UserController@changeSelfPassword');
            });
        });
    });
});
