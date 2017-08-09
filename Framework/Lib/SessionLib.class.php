<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionLib
 *
 * @author Joe
 */
class SessionLib {
    //put your code here
    private $db;
    public function __construct() {
        //ini_set('session.save_handle', 'user'); //自定义会话存储
        
        //用户自定义存储
        session_set_save_handler(
            array($this,'open'),
            array($this,'close'),
            array($this,'read'),
            array($this,'write'),
            array($this,'destroy'),
            array($this,'gc')
        );
    }
    
    /**
     * 打开会话
     */
    public function open(){
        //echo 'open'.'<br>';
        $this->db = MySQLDB::getInstance();      
    }
    
    /**
     * 读取会话
     * @param string $session_id 会话编号
     */
    public function read($session_id){
        //echo 'read'.'<br>';
        $sql = "select session_value from session where session_id='$session_id'";
      
        return $this->db->fetchColumn($sql);
    }
    
    /**
     * 写入会话
     * @param string $session_id 会话编号
     */
    public function write($session_id,$session_value){
        //echo 'write'.'<br>';
        $time = time();
        $sql = "insert into session(session_id,session_value,expires) values('$session_id','$session_value',$time) on duplicate key update session_value='$session_value'";
        return $this->db->query($sql);
    }
    
    /**
     * 关闭会话
     */
    public function close(){
        //echo 'close'.'<br>';
        return true;
    }
    
    /**
     * 销毁会话,销毁自己的会话
     * @param string $session_id 会话编号
     */
    public function destroy($session_id){
        //echo 'destroy'.'<br>';
        $sql = "delete from session where session_id='$session_id'";
        return $this->db->query($sql);
    }
    
    /**
     * 垃圾回收,所有的过期会话
     * @param int $maxlifetime 过期时间戳
     */
    public function gc($maxlifetime){
        //echo 'gc'.'<br>';
        $time = time() -$maxlifetime;
        $sql = "delete from session where expires<$time";        
        return $this->db->query($sql);
    }
}
