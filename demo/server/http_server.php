<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/2/28
 * Time: 上午1:39
 */
$http = new swoole_http_server("0.0.0.0", 9911);

//添加测试一：获取参数并打印出来
//$http->on('request', function ($request, $response) {
//    $response->cookie("singwa",'xsssss', time() + 1800);
//    $response->end('sss'.json_encode($request->get));
// });

/**
 * https://wiki.swoole.com/wiki/page/783.html
 * 配置静态文件根目录，与enable_static_handler配合使用。
 * 设置document_root并设置enable_static_handler为true后，
 * 底层收到Http请求会先判断document_root路径下是否存在此文件，
 * 如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
 */
$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/home/wwwroot/www.lingyuan88.com/public/swoole/data",
    ]
);
$http->on('request', function($request, $response) {
    //print_r($request->get);
    $content = [
        'date:' => date("Ymd H:i:s"),
        'get:' => $request->get,
        'post:' => $request->post,
        'header:' => $request->header,
    ];

    swoole_async_writefile(__DIR__."/access.log", json_encode($content).PHP_EOL, function($filename){
        // todo
    }, FILE_APPEND);
    $response->cookie("singwa", "xsssss", time() + 1800);
    $response->end("sss". json_encode($request->get));
});


$http->start();
