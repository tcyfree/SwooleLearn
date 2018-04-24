<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/14
 * Time: 上午1:40
 */
$process = new swoole_process(function(swoole_process $pro) {
    // todo
//     php redis.php
    $pro->exec("/usr/local/php/bin/php", [__DIR__.'/../server/http_server.php']);
}, false);

$pid = $process->start();
echo $pid . PHP_EOL;
//回收结束运行的子进程
swoole_process::wait();
