<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-11-12
 * Time: 10:26
 */

$http = new swoole_http_server('0.0.0.0',8001);
$http->on('request',function ($request,$response){
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1',6379);
    $value = $redis->get($request->get['a']);

    $response->end($value);
});

$http->start();