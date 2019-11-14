<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-09-27
 * Time: 11:54
 */

class ws
{
    const HOST = "0.0.0.0";
    const PORT = 8812;
    protected $ws;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->set(
            [
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     *
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
        if($request->fd == 1){
            // 毫秒定时器
            swoole_timer_tick(2000,function ($timerId){
                echo "2s:timerId:{$timerId}\n";
            });
        }
    }

    /**
     * 监听ws消息事件
     *
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ser-push-message:{$frame->data}\n";
        // 异步任务
        $data = [
            'task' => 1,
            'fd'   => $frame->fd
        ];
        $this->ws->task($data);

        // 异步定时器
        swoole_timer_after(5000,function () use($ws,$frame){
            echo "5s-after\n";
            $this->ws->push($frame->fd, "server-time-after:");
        });


        $this->ws->push($frame->fd, "server-push:" . date('Y-m-d H:i:s'));
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $workId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workId, $data)
    {
        print_r($data);
        // 耗时场景 10s
        sleep(10);
        return "task finish";
    }

    public function onFinish($serv, $taskId, $data)
    {
        echo "taskId:{$taskId}\n";
        echo "finish-data-success:{$data}\n";
    }

    /**
     *
     */
    public function onClose($ws, $fd)
    {
        echo "client:{$fd} closed\n";
    }
}

new ws();