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
//此事件在Worker进程/Task进程启动时发生,这里创建的对象可以在进程生命周期内使用
$http->on('WorkerStart', function(swoole_server $server,  $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../../../../application/');
    // 加载框架里面的文件
    require __DIR__ . '/../../../../thinkphp/base.php';
});
$http->on('request', function($request, $response) use($http){
    /**
     * 解决上一次输入的变量还存在的问题
     * 方案一：if(!empty($_GET)) {unset($_GET);}
     * 方案二：$http-close();把之前的进程kill，swoole会重新启一个进程，重启会释放内存，把上一次的资源包括变量等全部清空
     * 方案三：$_SERVER  =  []
     */
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

    $_GET = [];
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
    //把之前的进程kill，swoole会重新启一个进程，重启会释放内存，把上一次的资源包括变量等全部清空
    //$http->close();
});

$http->start();
