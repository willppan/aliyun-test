<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-10-08
 * Time: 10:20
 */
$content = date('Ymd H:i:s').PHP_EOL;
swoole_async_writefile(__DIR__.'/1.log',$content,function($filename){
    echo "success".PHP_EOL;
},FILE_APPEND);
echo "start".PHP_EOL;