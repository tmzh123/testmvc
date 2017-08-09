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
                echo '<br>';
                echo $_SESSION['name'];
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
