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
		require __VIEW__.'list.html';
	}

	//添加
	public function addAction(){
            echo '添加';

            if(empty($_POST) ){                    
                require __VIEW__.'add.html';            
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
                        echo $thumb_path;
                    }
                    
                    if($this->stuModel->insert($data)) {
                        $this->success('index.php?p=Admin&c=Student&a=list', '添加成功');
                    }else{
                        $this->error('index.php?p=Admin&c=Student&a=add', '添加错误');
                    }
                    
                }
            } catch (Exception $ex){                
                $this->error('index.php?p=Admin&c=Student&a=add', $ex->getMessage());
                exit;
            }
            
            
	}

	//修改
	public function modifyAction(){
		echo '修改';
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
