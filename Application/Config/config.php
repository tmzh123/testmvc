<?php 

return array(
    //数据库的配置信息
    'database'=> array(
        'host' => '127.0.0.1',
        'port' => '3306',
        'username' => 'root',
        'password' => 'joe123456',
        'dbname' => 'db_test'
    ),
    //应用程序的配置信息
    'app'=>array(
        'default_platform'      =>  'Admin',
        'default_controller'    => 'Student',
        'default_action'        => 'list',
        'key'                   => 'joe'
    )
);

 ?>