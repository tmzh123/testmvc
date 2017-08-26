<?php 



class StudentController extends BaseController {
	private $stuModel;

	public function __construct(){
                parent::__construct();
		$this->stuModel = new StudentModel();
	}

	//获取所有学生
	public function listAction(){
		$result = $this->stuModel->getList();
		//require __VIEW__.'list.html';
                
                $this->smarty->assign('title','学生页');
                $this->smarty->assign('stuList',$result);
                $this->smarty->display(__VIEW__.'student'.DS.'list.html');
	}
        
        /**
         * 添加|修改
         */
        public function operateAction(){
            
            if(isset($_REQUEST['id']) && $_REQUEST['id'] > 0){
                //修改
                $this->modifyAction();
            }else{
                //添加
                $this->addAction();
            }
        }
        
	//添加
	public function addAction(){
            if(empty($_POST) ){     
                $this->smarty->assign('title','学生页-添加');
                
                $stu = array('id'=>'','name'=>'','age' => 0,'user_photo'=>'');
                $this -> smarty -> assign('stu',$stu);
                $this->smarty->display(__VIEW__.'student'.DS.'operate.html');
                
                //require __VIEW__.'add.html';            
                exit;
            }
            
            $name = $_POST['name'];
            $age = $_POST['age'];
            $file = $_FILES['image'];
            
            $data = array();
            $data['name'] = $name;
            $data['age'] = $age;
            $uploadLib = new UploadLib();
            try{
                $path = $uploadLib->upload($file);
                if($path){
                    $data['user_photo'] = $path;
                    
                    //生成缩略图
                    $imageLib= new ImageLib();
                    $src_path = $GLOBALS['config']['app']['upload_path'].$path;
                    if( $thumb_path = $imageLib->thumb($src_path, 50, 50) ){
                        //echo $thumb_path;
                    }
                    
                    if($this->stuModel->insert($data)) {
                        $this->success('index.php?p=Admin&c=Student&a=list', '添加成功');
                    }else{
                        $this->error('index.php?p=Admin&c=Student&a=operate', '添加错误');
                    }
                }else{
                    $this->error('index.php?p=Admin&c=Student&a=add','图片上传失败:'.$uploadLib->getError());
                }
            } catch (Exception $ex){                
                $this->error('index.php?p=Admin&c=Student&a=add', $ex->getMessage());
                exit;
            }
	}

	//修改
	public function modifyAction(){
            if(!empty($_GET) && (isset($_GET['id']) ) ){
                $id = $_GET['id'];
                
                $stu =  $this->stuModel->single($id);
                
                $this->smarty->assign('title','学生页-修改');
                $this -> smarty -> assign('stu',$stu);
                $this->smarty->display(__VIEW__.'student'.DS.'operate.html');
                exit;
            }  
            
            if(!empty($_POST)){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $age = $_POST['age'];
                $file = $_FILES['image'];
                

                $data = array();
                $data['id'] = $id;
                $data['name'] = $name;
                $data['age'] = $age;
                
                $uploadLib = new UploadLib();

                try{
                    $path = $uploadLib->upload($file);
                    if($path){
                        $data['user_photo'] = $path;

                        //生成缩略图
                        $imageLib= new ImageLib();
                        $src_path = $GLOBALS['config']['app']['upload_path'].$path;
                        if( $thumb_path = $imageLib->thumb($src_path, 50, 50) ){
                            //echo $thumb_path;
                        }
                    }else{
                        $this->error('index.php?p=Admin&c=Student&a=add','图片上传失败:'.$uploadLib->getError());
                    }
                } catch (Exception $ex){           
                }                    
                
                if($this->stuModel->update($data)) {
                    $this->success('index.php?p=Admin&c=Student&a=list', '修改成功');
                }else{
                    $this->error('index.php?p=Admin&c=Student&a=operate', '修改错误');
                }
                
            }
            
	}

	//删除
	public function delAction(){
		$id = isset($_GET["id"]) ? $_GET['id'] : 0;
		$result = $this->stuModel->del($id);
		if($result){
			header('location:index.php?c=Student&a=list');
		}else{
			echo '删除失败';
		}
	}
        
        /**
         * 测试session
         */
        public function testSessionAction(){
            echo 'testSessionAction<br>';
            $_SESSION['name'] = '赵六';
            echo $_SESSION['name'];
        }
        
        
}
 ?>
