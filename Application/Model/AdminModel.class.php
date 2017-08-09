<?php

/**
 * Description of AdminModel
 *
 * @author Joe
 */
class AdminModel extends BaseModel {
    //put your code here
    
    /**
     * 判断用户登录
     * @param string $username
     * @param string $password 
     * @return type
     */
    public function checkLogin($username,$password){
        $username = mysqli_real_escape_string($this->db->dbLink,$username);
        $password = md5($password);
        $sql = "select * from admin where username='$username' and password='$password'";
        return $this->db->fetchRow($sql);
    }
    
    /**
     * 通过cookie登录
     */
    public function checkLoginByCookie(){
        if(!isset($_COOKIE['id']) || !isset($_COOKIE['up']) || isset($_SERVER['HTTP_REFERER']))
        {
            return false;
        }
        $id = mysqli_real_escape_string($this->db->dbLink, $_COOKIE['id']);
        $up = $_COOKIE['up'];
        $sql = "select * from admin where id=$id";
        $info = $this->db->fetchRow($sql);
        if($info){
            if($up == md5($info['username'].$info['password'].$GLOBALS['config']['app']['key'])){
                return $info;
            }
        }
        return false;
    }
    
    /**
     * 登录成功后,修改登录信息
     */
    public function updateLoginInfo(){
        $ip = ip2long($_SERVER['REMOTE_ADDR']);
        $time = time();
        $id = $_SESSION['admin']['id'];
        
        $sql = "update admin set last_login_ip=$ip,last_login_time=$time where id=$id";
        $this->db->query($sql);
                
    }
}
