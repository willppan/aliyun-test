<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-09-16
 * Time: 09:57
 */

// 实例化websocket服务
$server = new swoole_websocket_server("0.0.0.0",8812);

$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/Users/panwei/mytest/test/swoole/demo/data"
    ]
);

// 监听websocket连接打开事件
$server->on('open','onOpen');
function onOpen($sever,$request){
    print_r($request->fd);
}
// 监听websocket消息事件
$server->on('message', function(swoole_websocket_server $server, $frame){
    echo "receive from {$frame->fd} : {$frame->data} , opcode:{$frame->opcode} , fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser,$fd){
    echo "client {$fd} closed\n";
});

$server->start();