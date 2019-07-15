<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-15
 * Time: 21:51
 */

go(function () {
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    if($redis) {
        echo "connect".PHP_EOL;
        $res = $redis->set('geng_1', time());
        var_dump($res);
        $res2 = $redis->get('geng_1');
        var_dump($res2);
        $res3 = $redis->keys('*1*');
        var_dump($res3);
    }
});

echo "start".PHP_EOL;
