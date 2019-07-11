<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-11
 * Time: 22:13
 */
use Swoole\Coroutine as co;


$filename = __DIR__ . "/1.log";
$content = date("Ymd H:i:s").PHP_EOL;
co::create(function () use ($filename, $content) {
    $r =  co::writeFile($filename, $content, FILE_APPEND);
    var_dump($r);
});

echo "start".PHP_EOL;