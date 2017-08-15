<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CaptchaLib
 *
 * @author Joe
 */
class CaptchaLib {
    //put your code here
    
    private $length;
    public function __construct($length = 4) {
        $this->length=$length;
    }


    private function generateCode(){
        $arr = array_merge(range('A', 'Z'),range('a', 'z'),range(0, 9));
        $arr_index =  array_rand($arr,$this->length);
        shuffle($arr_index);

        //拼接字符串
        $str = '';
        foreach ($arr_index as $i) {
                $str.=$arr[$i];
        }
        return $str;
    }

    public function generateCaptcha(){
        $str = $this->generateCode();
        $_SESSION['captcha'] = $str;
        $imagePath = LIB_PATH.'/captcha/captcha_bg'.rand(1,5).'.jpg';
        $img = imagecreatefromjpeg($imagePath);
        $color = imagecolorallocate($img, 255, 255, 255);
        if(rand(1,2) == 2){
            $color = imagecolorallocate($img, 0, 0, 255);
        }

        $font = 5;		

        $x = (imagesx($img) - imagefontwidth($font) * 4)  * 0.5;
        $y = (imagesy($img) - imagefontheight($font)) * 0.5;

        imagestring($img, $font, $x, $y, $str, $color);

        header('content-type:image/jpeg');
        imagepng($img);
        imagedestroy($img);
    }
    
    /**
     * 校验验证码
     * @param string $code
     */
    public function checkCode($code){
        return strtoupper($code)== strtoupper($_SESSION['captcha']);
    }


}
