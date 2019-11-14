<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-09-27
 * Time: 16:26
 */

// 异步文件读取（最大4m）
$res = swoole_async_readfile(__DIR__."/1.txt",function ($fileName,$fileContent){
    echo "fileName:".$fileName.PHP_EOL;
    echo "content:".$fileContent.PHP_EOL;
});

var_dump($res);

echo "start".PHP_EOL;

// 异步文件读取（可分段读取）
swoole_async_read(__DIR__."/1.txt",function ($fileName,$fileContent){
    echo "fileName:".$fileName.PHP_EOL;
    echo "content:".$fileContent.PHP_EOL;
},10);
