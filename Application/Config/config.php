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
        'key'                   => 'joe',
        
        'upload_path'   =>  './Public/uploads/',
        'upload_type'   =>  array('image/jpeg','image/png','image/gif'),
        'upload_size'   =>  10000000,
        'app_debug'     =>  false    //true表示开发模式，false表示运行模式
    )
);

 ?>