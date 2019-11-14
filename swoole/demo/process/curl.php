<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-11-04
 * Time: 15:33
 */

echo "process-start-time:".date('Ymd H:i:s').PHP_EOL;
$workers = [];
$urls = [
    'http://baidu.com',
    'http://sina.com.cn',
    'http://qq.com',
    'http://baidu.com?search=123',
    'http://baidu.com?search=231',
    'http://baidu.com?search=1412',
];

foreach($urls as $url){
    $process = new swoole_process(function (swoole_process $worker) use($url){
        $content = curlData($url);
        $worker->write($content);
    },true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $worker) {
    echo $worker->read();
}

function curlData($url){
    sleep(1);
    return $url.'-success'.PHP_EOL;
}

echo "process-end-time:".date('Ymd H:i:s');