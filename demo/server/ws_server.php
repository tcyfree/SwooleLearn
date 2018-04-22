<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/1
 * Time: 下午11:45
 */

$server = new swoole_websocket_server("0.0.0.0", 8812);
//$server->set([]);
$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/home/work/hdtocs/swoole_mooc/data",
    ]
);
//监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen($server, $request) {
    print_r($request->fd);
}

// 监听ws消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "singwa-push-secesss");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();