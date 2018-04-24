<?php
/**
 * descript: phpstrom
 * User: singwa
 * Date: 18/3/7
 * Time: 上午1:53
 */

/**
 * 读取文件
 * __DIR__
 */
//函数风格
$result = swoole_async_readfile(__DIR__."/1.txt", function($filename, $fileContent) {
    echo "filename:".$filename.PHP_EOL;  // \n \r\n
    echo "content:".$fileContent.PHP_EOL;
});
//命名空间风格
$result = Swoole\Async::readfile(__DIR__."/1.txt", function($filename, $fileContent) {
    echo "filename:".$filename.PHP_EOL;  // \n \r\n
    echo "content:".$fileContent.PHP_EOL;
});

var_dump($result);
echo "start".PHP_EOL;