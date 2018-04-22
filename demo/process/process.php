<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/14
 * Time: 上午1:40
 */
$process = new swoole_process(function(swoole_process $pro) {
    // todo
    // php redis.php
    $pro->exec("/home/work/study/soft/php/bin/php", [__DIR__.'/../server/http_server.php']);
}, false);

$pid = $process->start();
echo $pid . PHP_EOL;

swoole_process::wait();
