<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/2/28
 * Time: 上午1:39
 */
$http = new swoole_http_server("0.0.0.0", 9911);

$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/home/wwwroot/swoole/thinkphp/public/static",
        'worker_num' => 5,
    ]
);
$http->on('WorkerStart', function(swoole_server $server,  $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    // 加载框架里面的文件
    require __DIR__ . '/../../../../thinkphp/base.php';
    //require __DIR__ . '/../../../../thinkphp/start.php';
});
$http->on('request', function($request, $response) use($http){

    //define('APP_PATH', __DIR__ . '/../application/');
    //require __DIR__ . '/../thinkphp/base.php';
    $_SERVER  =  [];
    if(isset($request->server)) {
        foreach($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->header)) {
        foreach($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }

    $_GET = [];//解决上一次输入的变量还存在的问题，方案二：if(!empty($_GET)) {unset($_GET);}，方案三：$http-close();把上一次的资源包括变量等全部清空
    if(isset($request->get)) {
        foreach($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    //开启缓冲区
    ob_start();
    // 执行应用并响应
    try {
        think\Container::get('app', [APP_PATH])
            ->run()
            ->send();
    }catch (\Exception $e) {
        // todo
    }

    //输出TP当前请求的控制方法
    //echo "-action-".request()->action().PHP_EOL;
    //获取缓冲区内容
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
    //把上一次的资源包括变量等全部清空
    //$http->close();
});

$http->start();

// topthink/think-swoole
