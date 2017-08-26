<?php

/**
 * Description of LoginController
 *
 * @author Joe
 */
class LoginController extends BaseController {
    //put your code here
    
    
    public function loginAction(){
        $adminModel = new AdminModel();        
        //正常登录
        if(!empty($_POST)){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $code = $_POST['captcha'];
            $captcha = new CaptchaLib();
            if(!$captcha->checkCode($code)){
                $this->error('index.php?p=Admin&c=Login&a=login','验证码错误');
                exit;
            }
            $info = $adminModel->checkLogin($username, $password);
            if($info){
                if(isset($_POST['remember']) && $_POST['remember'] == 1){
                    setcookie('id',$info['id'],PHP_INT_MAX);
                    setcookie('up',md5($info['username'].$info['password'].$GLOBALS['config']['app']['key']),PHP_INT_MAX);
                }
                $_SESSION['admin'] = $info;
                $adminModel ->updateLoginInfo();
                $this->success('index.php?p=Admin&c=Admin&a=admin','登录成功',1);
            }else{
                $this->error('index.php?p=Admin&c=Login&a=login','登录失败');
            }
            //$this->success('index.php?p=Admin&c=Admin&a=admin');
            exit;
        }        
        
        //cookie登录
        $info = $adminModel->checkLoginByCookie();
        if($info){
            
            $_SESSION['admin'] = $info;
            $adminModel ->updateLoginInfo();
            $this->success('index.php?p=Admin&c=Admin&a=admin','登录成功',1);
            exit;
        }
        
        require __VIEW__.'login.html';
    }
    
    /**
     * 登出
     */
    public function loginoutAction(){
        //删除cookie
        //删除session
        setcookie('id',false);
        setcookie('up',false);
        session_destroy();
        $this->success('index.php?p=Admin&c=Login&a=login');
    }
    
    /**
     * 生成验证码
     */
    public function captchaAction(){
        $captcha = new CaptchaLib();
        $captcha->generateCaptcha();
    }
            
    
}
