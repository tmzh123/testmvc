<?php 

//模型基类(负责公用的方法和属性)
class BaseModel{

	protected $db;		//数据库对象

	public function __construct(){
        $this->initDB();
	}

	private function initDB(){
        $this->db = MySQLDB::getInstance();
    }

}

 ?>