<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-10-10
 * Time: 09:53
 */

$redis = new swoole_redis;
$redis->connect('127.0.0.1',6379, function(swoole_redis $redis, $result){
    echo "content".PHP_EOL;
    var_dump($result);

    $redis->set('test', time(), function (swoole_redis $redis, $result){
        var_dump($result);
    });

    $redis->get('test', function (swoole_redis $redis, $result){
        var_dump($result);
    });

    $redis->keys('*test*', function (swoole_redis $redis, $result){
        var_dump($result);
    });
    $redis->close();
});

echo "start".PHP_EOL;