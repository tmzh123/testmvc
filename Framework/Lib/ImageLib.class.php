<?php


class ImageLib{
    private $error;
    public function getError(){
        return $this->error;
    }
    /*
     * 制作缩略图
     * @param $src_path string 源图的路径
     * @param $max_w int 画布的宽度
     * @param $max_h int 画布的高度
     * @param $flag bool 是否等比
     * @param $prefix string 缩略图的前缀 
     */
    public function thumb($src_path,$max_w,$max_h,$prefix='s_',$flag=false){
        $ext=  strtolower(strrchr($src_path,'.'));  //获取文件的后缀
        switch($ext){
            case '.jpg':
                $type='jpeg';
                break;
            case '.gif':
                $type='gif';
                break;
            case '.png':
                $type='png';
                break;
            default:
                $this->error='文件格式不正确';
                return false;
        }
        $open_fn='imagecreatefrom'.$type;   //拼接打开图片的函数
        $src=$open_fn($src_path);    //打开源图
        $dst=imagecreatetruecolor($max_w,$max_h);   //创建目标图
        $src_w=imagesx($src);   //源图的宽度
        $src_h=imagesy($src);   //源图的高度
        if($flag){  //等比缩放
            if($max_w/$max_h<$src_w/$src_h){
                    $dst_w=$max_w;
                    $dst_h=$max_w*$src_h/$src_w;
            }else {
                    $dst_h=$max_h;
                    $dst_w=$max_h*$src_w/$src_h;
            }
            //在目标图上显示的位置
            $dst_x=(int)(($max_w-$dst_w)/2);
            $dst_y=(int)(($max_h-$dst_h)/2);
        }else{   //不等比
            $dst_x=0;
            $dst_y=0;
            $dst_w=$max_w;
            $dst_h=$max_h;
        }
        //生成缩略图
        imagecopyresampled($dst,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$src_w,$src_h);
        $filename=basename($src_path);  //文件名称
        $foldername=substr(dirname($src_path),-10); //文件夹名
        $thumb_path=$GLOBALS['config']['app']['upload_path'].$foldername.DS.$prefix.$filename;
        imagepng($dst,$thumb_path);
        imagedestroy($dst);
        imagedestroy($src);
        return $foldername.'/'.$prefix.$filename;
    }
}