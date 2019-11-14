<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-08-11
 * Time: 10:36
 */

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new Swoole\Server("127.0.0.1", 9501);

$serv->set([
    'worker_num' => 5, // worker进程数 cpu 1-4
    'max_request' => 10000 //此参数表示worker进程在处理完n次请求后结束运行。manager会重新创建一个worker进程。此选项用来防止worker进程内存溢出。
]);
//监听连接进入事件
/*
 * $fd 客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('Connect', function ($serv, $fd, $reactor_id) {
    echo "Client:{$reactor_id} - {$fd}-Connect.\n";
});

//监听数据接收事件
$serv->on('Receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server:{$reactor_id}-{$fd} ".$data);
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();
