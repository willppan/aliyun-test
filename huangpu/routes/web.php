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



$router->addRoute(['GET','POST'],'/login', 'WebController@login'); // 登录
$router->addRoute(['GET','POST'],'/index', 'WebController@index'); // 首页

