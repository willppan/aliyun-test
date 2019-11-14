<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-08-11
 * Time: 15:14
 */
$http = new swoole_http_server("0.0.0.0",8811);
$http->set(
  [
      'enable_static_handler' => true,
      'document_root' => "/data/html/test/swoole/demo/data"
  ]
);
$http->on('request',function ($request,$response){
    $content = [
        'date' => date('Y-m-d H:i:s'),
        'get' => $request->get,
        'post' => $request->post,
        'header' => $request->header,
    ];
    swoole_async_writefile(__DIR__."/access.log",json_encode($content),function ($filename){
        //todo
    },FILE_APPEND);

    print_r($request->get);// 这里会在服务端输出
    $response->end(json_encode($request->get));// 在end中才会在客户端输出
});

$http->start();
