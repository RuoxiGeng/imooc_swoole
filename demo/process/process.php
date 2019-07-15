<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-15
 * Time: 22:25
 */

$process = new swoole_process(function (swoole_process $pro) {
    //执行 php 命令
    $pro->exec("/Users/ruoxigeng/swoole/php7/bin/php",
        [__DIR__.'/../server/http_server.php']);
}, false);

$pid = $process->start();
echo $pid.PHP_EOL;

swoole_process::wait();