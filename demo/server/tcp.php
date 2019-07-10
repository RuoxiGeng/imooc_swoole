<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-08
 * Time: 21:32
 */

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

/**
 * 设置基本参数
 */
$serv->set([
    'worker_num' => 4, //worker进程数 cpu 1-4
    'max_request' => 10000,
]);

//监听连接进入事件
/**
 * $fd 客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo "Client: {$reactor_id} - {$fd}-Connect.\n";
});

//监听数据接收事件
/**
 * $reactor_id 线程id
 */
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server: {$reactor_id} - {$fd}".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();