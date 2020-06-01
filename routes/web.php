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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('test', 'ExampleController@test');
$router->get('fetchDevices', 'ExampleController@getDevices');


$router->get('getToken', 'KaiOSController@getToken');
$router->get('getAccounts', 'KaiOSController@getAccounts');
$router->get('notifyPaid', 'KaiOSController@notifyPaid');
$router->get('getImei','KaiOSController@getDeviceImei');
$router->get('getImeiPing','KaiOSController@imeiPing');
$router->get('massPaymentnotify','KaiOSController@massPaymentnotify');
$router->get('creditCompletion','KaiOSController@creditCompletion');
$router->get('masscreditCompletionNotify','KaiOSController@masscreditCompletionNotify');
$router->get('/dashboard','DashboardController@getDashboard');
//


