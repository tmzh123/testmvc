<?php 

class StudentModel extends BaseModel{
	private $id;
	private $name;
	private $age;

	public function __get($key){
		return $this->$key;
	}

	public function __set($key,$value){
		$this->$key = $value;
	}

	public function getList(){
		return $this->db->fetchAll('select * from student');
	}

	//删除
	public function del($id){
		$sql = "delete from student where id=$id";
		return $this->db->query($sql);
	}
}



 ?>