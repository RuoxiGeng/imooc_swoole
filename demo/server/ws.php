<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-10
 * Time: 21:18
 * ws优化基础类库
 */

class Ws {

    CONST HOST = "0.0.0.0";
    CONST PORT = 3030;

    public $ws = null;
    public function __construct() {
        $this->ws = new Swoole_WebSocket_Server("0.0.0.0", 3030);

        $this->ws->set(
            [
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );

        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request) {
        var_dump($request->fd);
        if($request->fd == 1) {
            //每两秒执行
            swoole_timer_tick(2000, function ($timer_id) {
                echo "2s: timerId:{$timer_id}\n";
            });
        }
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame) {
        echo "ser-push-message:{$frame->data}\n"; //ws打印
        //执行10s task
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];

//        $ws->task($data);

        swoole_timer_after(5000, function () use($ws, $frame) {
            echo "5s-after\n";
            $ws->push($frame->fd, "server-time-after:");
        });
        $ws->push($frame->fd, "server-push:".date("Y-m-d H:i:s")); //ws异步返回客户端，不等待任务执行
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workerId, $data) {
        print_r($data);
        //耗时场景 10s
        sleep(10);
        return "on task finish"; //告诉worker
    }

    public function onFinish($serv, $taskId, $data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-success:{$data}\n";
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
        echo "clientid:{$fd}\n";
    }
}

$obj = new Ws();