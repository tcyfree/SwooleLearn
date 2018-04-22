<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/18
 * Time: 下午10:00
 */
// 创建内存表
$table = new swoole_table(1024);

// 内存表增加一列
$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 64);
$table->column('age', $table::TYPE_INT, 3);
$table->create();

$table->set('singwa_imooc', ['id' => 1, 'name'=> 'singwa', 'age' => 30]);
// 另外一种方案
$table['singwa_imooc_2'] = [
    'id' => 2,
    'name' => 'singwa2',
    'age' => 31,
];

$table->decr('singwa_imooc_2', 'age', 2);
print_r($table['singwa_imooc_2']);

echo "delete start:".PHP_EOL;
$table->del('singwa_imooc_2');

print_r($table['singwa_imooc_2']);
