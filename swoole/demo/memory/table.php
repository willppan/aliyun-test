<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-11-04
 * Time: 16:14
 */
// 实例化内存表
$table = new swoole_table(1024);
// 内存表增加一列
$table->column('id', $table::TYPE_INT, 8);
$table->column('name', $table::TYPE_STRING, 60);
$table->column('age', $table::TYPE_INT, 3);
// 创建表
$table->create();
// 新增数据
$table->set('pw', ['id' => 1, 'name' => 'panwei', 'age' => 25]);
// 读取数据
print_r($table->get('pw'));

// 另一种方式
$table['pw2'] = [
    'id' => 2,
    'name' => 'panwei2',
    'age' => 24
];

$table->incr('pw2','age',100);
print_r($table['pw2']);

$table->decr('pw2','age',50 );
print_r($table['pw2']);

echo 'delete-start'.PHP_EOL;
$table->del('pw2');
echo 'delete-end'.PHP_EOL;
print_r($table['pw2']);