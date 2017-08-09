<?php

/**
 * Description of LoginController
 *
 * @author Joe
 */
class LoginController extends BaseController {
    //put your code here
    
    
    public function loginAction(){
        if(!empty($_POST)){
            $this->success('index.php?p=Admin&c=Admin&a=admin');
            exit;
        }        
        require __VIEW__.'login.html';
    }
    
    /**
     * 登出
     */
    public function loginoutAction(){
        $this->success('index.php?p=Admin&c=Login&a=login');
    }
}
