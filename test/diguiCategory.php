<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$conn = mysqli_connect('127.0.0.1:3306', 'root', 'joe123456', 'db_test') or die('数据库连接失败');

$sql = 'select * from category order by sort_order asc';

$rs = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($rs)) {
    $data[] = $row;
}


function createTree($list,$parentId = 0,$deep = 0){
    static $tree = array();
    foreach ($list as $row) {
        if($row['parentid'] == $parentId){
            $row['deep'] = $deep;
            $tree[] = $row;
            createTree($list, $row['id'], $deep+1);
        }
    }
    return $tree;
}

echo '<pre>';
var_dump(createTree($data));
