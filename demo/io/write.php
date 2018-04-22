<?php
/**
 * descript: phpstrom
 * User: singwa
 * Date: 18/3/7
 * Time: 上午2:05
 */

$content = date("Ymd H:i:s").PHP_EOL;
swoole_async_writefile(__DIR__."/1.log", $content, function($filename){
    // todo
    echo "success".PHP_EOL;
}, FILE_APPEND);
// file_put_contents();
echo "start".PHP_EOL;