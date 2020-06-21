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
$router->get('massPaymentnotifyTest','KaiOSController@massPaymentnotifyTest');
$router->get('creditCompletion','KaiOSController@creditCompletion');
$router->get('masscreditCompletionNotify','KaiOSController@masscreditCompletionNotify');
$router->get('masscreditCompletionNotifyTest','KaiOSController@masscreditCompletionNotifyTest');
$router->get('/dashboard','DashboardController@getDashboard');
$router->get('/myTestRoute','DashboardController@getDashboard');
$router->post('oauth2/v1.0/challenges','KaiOSController@challenges');
$router->put('oauth2/v1.0/challenges/e2NiOgogbh6b25X3p2TQ','KaiOSController@challengeCompletion');
$router->post('oauth2/v1.0/secured_tokens','KaiOSController@secureToken');
$router->post('financier_fe/v1.0/pushsubs','KaiOSController@pushsubs');
$router->put('financier_fe/v1.0/pings/{ping_id}','KaiOSController@pingResponse');
$router->get('financier_fe/v1.0/cmds','KaiOSController@deviceFetchCommands');
$router->delete('financier_fe/v1.0/cmds/{msg id}?ack=true','KaiOSController@deviceAckCommandExecution');
$router->post('financier_fe/v1.0/status','KaiOSController@deviceVoluntaryStatusReport');
$router->post('financier_fe/v1.0/registrations','KaiOSController@deviceFinancierRegistrationInitiation');
$router->put('financier_fe/v1.0/registrations/{id}','KaiOSController@deviceFinancierRegistrationCompletion');
$router->get('financier_be/v1.0/devices','KaiOSController@fetchAllDevices');
$router->get('financier_be/v1.0/devices/{imei}','KaiOSController@fetchSpecificDeviceOfanAccount');
$router->get('financier_be/v1.0/devices/{imei}/cmd[?deleted=true]','KaiOSController@fetchCmdQueueofSpecificDevice');
$router->post('financier_be/v1.0/devices/{imei}/notify_paid','KaiOSController@notifyDeviceInstallmentPayment');
$router->post('financier_be/v1.0/devices/notify_paid','KaiOSController@massDevicePayment');
$router->post('financier_be/v1.0/devices/{imei}/notify_credit_completed','KaiOSController@notifyDeviceCreditCompletion');
$router->post('financier_be/v1.0/devices/notify_paid','KaiOSController@massDeviceCreditCompletion');


//


