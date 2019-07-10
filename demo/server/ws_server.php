<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-09
 * Time: 22:39
 */
$server = new Swoole_WebSocket_Server("0.0.0.0", 3030);

$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/Users/ruoxigeng/imooc_swoole/data",
    ]
);

//监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen($server, $request) {
    print_r($request->fd);
}

//监听ws消息事件
$server->on('message', function (Swoole_WebSocket_Server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "geng-push-success");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();