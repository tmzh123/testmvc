<?php 


    ini_set('session.save_handle', 'user'); //自定义会话存储
    $db_link = null;
    
    /**
     * 打开会话
     */
    function open(){
        echo 'open'.'<br>';
        $GLOBALS['db_link'] = mysqli_connect('127.0.0.1:3306', 'root', 'joe123456', 'db_test') or die('数据库连接失败');        
    }
    
    /**
     * 读取会话
     * @param string $session_id 会话编号
     */
    function read($session_id){
        echo 'read'.'<br>';
        $sql = "select session_value from session where session_id='$session_id'";
        if(!isset($GLOBALS['db_link'])){
            open();
        }
        $result = mysqli_query($GLOBALS['db_link'], $sql);
        if($result)
        {            
            return mysqli_fetch_field($result);
        }
        return null;        
    }
    
    /**
     * 写入会话
     * @param string $session_id 会话编号
     */
    function write($session_id,$session_value){
        echo 'write'.'<br>';
        $time = time();
        if(!isset($GLOBALS['db_link'])){
            open();
        }
        echo '<br>';
        $sql = "insert into session(session_id,session_value,expires) values('$session_id','$session_value',$time) on duplicate key update session_value='$session_value'";
        return mysqli_query($GLOBALS['db_link'], $sql);
    }
    
    /**
     * 关闭会话
     */
    function close(){
        echo 'close'.'<br>';
    }
    
    /**
     * 销毁会话,销毁自己的会话
     * @param string $session_id 会话编号
     */
    function destroy($session_id){
        echo 'destroy'.'<br>';
        $sql = "delete from session where session_id='$session_id'";
        
        if(!isset($GLOBALS['db_link'])){
            open();
        }
        return mysqli_query($GLOBALS['db_link'], $sql);
    }
    
    /**
     * 垃圾回收,所有的过期会话
     * @param int $maxlifetime 过期时间戳
     */
    function gc($maxlifetime){
        echo 'gc'.'<br>';
        $time = time() -$maxlifetime;
        $sql = "delete from session where expires<$time";
        
        if(!isset($GLOBALS['db_link'])){
            open();
        }
        return mysqli_query($GLOBALS['db_link'], $sql);
    }
    
    session_set_save_handler('open', 'close', 'read', 'write', 'destroy', 'gc');
    session_start();
    
    $_SESSION['name'] = '张三';
    //session_destroy();
    
    $_SESSION['name'] = '李四';