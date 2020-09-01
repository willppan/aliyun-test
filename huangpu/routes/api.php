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

$router->post('do_login', 'LoginController@index');
$router->get('logout', 'LoginController@logout');

$router->post('register', 'RegisterController@index');
$router->post('search', 'RegisterController@search');

$router->post('visit', 'VisitController@index');

$router->post('search_download', 'WordController@index');
$router->get('download', 'WordController@download');

$router->group([
    'middleware' => 'auth',
], function () use ($router) {
    $router->get('count', 'VisitController@count');

    $router->get('list', 'ListController@index');
    $router->get('export', 'ListController@export');
});

