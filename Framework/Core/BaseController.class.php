<?php

class BaseController{
    public function __construct() {
        $this->initSession();
    }
    
    private function initSession(){
        new SessionLib();
        session_start();
    }
    
    /**
     * 成功跳转的方法
     * @param string $url 跳转的地址
     * @param string $msg 显示信息,如果为空直接跳转
     * @param int $time 页面停留时间
     */
    public function success($url,$msg='',$time=3){
        $this->jump($url, $msg, $time, true);
    }
    
    /**
     * 失败的跳转
     * @param string $url 跳转的地址
     * @param string $msg 显示信息,如果为空直接跳转
     * @param int $time 页面停留时间
     */
    public function error($url,$msg='',$time=3){
        $this->jump($url, $msg, $time, false);
    }
    
    /**
     * 跳转的方法
     * @param type $url
     * @param type $msg
     * @param type $time
     * @param type $flag
     */
    private function jump($url,$msg='',$time=3,$flag =true){
        if($msg == ''){
            header("location:{$url}");            
        }
        else{
            if($flag){
                $path = '<img src="/Public/images/success.jpg" />';
            }
            else{                
                $path = '<img src="/Public/images/error.jpg" />';              
            }
            echo 
<<<jump
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="{$time};URL={$url}" />
<title>无标题文档</title>
<style type="text/css">
body{
    text-align:center;
    font-size:20px;
    background-color:#F90;
    color:#F00;
    padding-top:30px;
    font-family:'微软雅黑'
}
</style>
</head>

<body>
{$path}
{$msg}
</body>
</html>
jump;
                }
    }
    
}