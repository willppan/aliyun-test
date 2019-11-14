<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-10-10
 * Time: 15:25
 */

$process = new swoole_process(function (swoole_process $process){
    echo "子进程开启".PHP_EOL;
    $process->exec('/usr/local/php/bin/php',
        [__DIR__."/../server/http_server.php"]);

},false);

$pid = $process->start();
echo "子进程pid:".$pid.PHP_EOL;

swoole_process::wait();
