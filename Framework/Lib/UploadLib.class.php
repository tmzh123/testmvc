<?php

/**
 * 上传类
 */
class UploadLib{
    private $path;  //文件上传的路径
    private $type;  //文件上传的类型
    private $size;  //允许文件上传的大小
    private $error; //上传过程中产生的错误
    
    //通过构造函数初始化成员变量
    public function __construct() {
        $this->path = $GLOBALS['config']['app']['upload_path'];
        $this->type = $GLOBALS['config']['app']['upload_type'];
        $this->size = $GLOBALS['config']['app']['upload_size'];
    }
    
    //获取错误
    public function getError(){
        return $this->error;
    }
    
    /*
     * 文件上传类
     * @param $file $_FILES对象
     */
    public function upload($file){
        $error=$file['error'];
        //判断错误类型
        if($error) {
            switch($error) {
                case 1:
                    $this->error='上传文件大小超过了配置文件中允许的最大值';
                    return false;
                case 2:
                    $this->error= '上传文件大小超过了表单允许的最大值';
                     return false;
                case 3:
                    throw new Exception('文件没有上传完整');
                    //$this->error= '文件没有上传完整';
                     //return false;
                case 4:
                    throw new Exception('没有上传文件');
                    //$this->error= '没有上传文件';
                     //return false;
                case 6:
                    $this->error= '找不到临时文件'; 
                     return false;
                case 7:
                    $this->error= '文件写入失败';
                     return false;
                default:
                    $this->error= '未知错误';
                     return false;
            }
        }
        //验证格式
        if(!in_array($file['type'],$this->type)){
                $this->error='类型类型不正确,只能是'.implode(',',$this->type);
                return false;
        }
        //验证大小
        if($file['size']>$this->size){
                $this->error='文件不能超过'.($this->size/1024).'K';
                return false;
        }
        //判断上传是否是http上传
        if(!is_uploaded_file($file['tmp_name'])){
            $this->error='文件必须是http上传';
            return false;
        }
        //创建文件夹
        $foldername=date('Y-m-d');   //文件夹名称
        $folderpath=$this->path.DS.$foldername;    //文件夹路径
        if(!file_exists($folderpath)){
            mkdir($folderpath);
        }
        //文件上传
        $filename=uniqid('',true).strrchr($file['name'],'.');   //文件名称
        $filepath=$folderpath.DS.$filename;    //文件路径
        if(move_uploaded_file($file['tmp_name'],$filepath)) {
            return "{$foldername}/{$filename}";
        }else {
            $this->error='上传失败';
            return false;
        }
    }
    
}
