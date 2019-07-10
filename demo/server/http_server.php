<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-09
 * Time: 21:45
 */
$http = new swoole_http_server("0.0.0.0", 8811);

//使用静态资源，不执行后面的逻辑
$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/Users/ruoxigeng/imooc_swoole/data",
    ]
);

$http->on('request', function($request, $response) {
//    $request->get == $_GET
    $response->cookie("geng", "xssss", time()+1800);
    $response->end("sss".json_encode($request->get));
});

$http->start();