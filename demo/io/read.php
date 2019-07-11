<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-11
 * Time: 21:48
 */
use Swoole\Coroutine as co;

/**
 * 读取文件
 * __DIR__
 */
$filename = __DIR__ . "/12.txt";
$res = co::create(function () use ($filename) {
    $filecontent =  co::readFile($filename);
    echo "filename:".$filename.PHP_EOL;
    echo "content:".$filecontent.PHP_EOL;
});

echo "start".PHP_EOL;