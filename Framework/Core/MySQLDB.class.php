<?php 

class MySQLDB {
	private $host;		//主机IP
	private $port;		//端口号
	private $username;	//用户名
	private $password;	//密码
	private $charset;	//字符编码
	private $dbname;	//链接的数据库
	private $dbLink;	//数据库连接对象
        
        
        public function __get($name) {
            return $this->$name;
        }

	private static $instance;

	private function __construct(){
		$this->initParam();
		$this->connect();
	}

	private function __clone(){}

	public static function getInstance(){
		if(!self::$instance instanceof self){
			self::$instance = new MySQLDB();
		}
		return self::$instance;
	}

	//初始化数据库
	private function initParam(){
        $dbConfig = $GLOBALS['config']['database'];
		$this->host = isset($dbConfig['host'])?$dbConfig['host']:'';
		$this->port = isset($dbConfig['port'])?$dbConfig['port']:'';
		$this->username = isset($dbConfig['username'])?$dbConfig['username']:'';
		$this->password = isset($dbConfig['password'])?$dbConfig['password']:'';
		$this->dbname = isset($dbConfig['dbname'])?$dbConfig['dbname']:'';
	}

	//链接数据库
	private function connect(){
		$this->dbLink = mysqli_connect("{$this->host}:{$this->port}",$this->username,$this->password,$this->dbname) or die('数据库连接失败');
	}

	/**
	* 执行SQL语句
	*/
	public function query($sql){
                $result = mysqli_query($this->dbLink,$sql);     
		if(!$result){
			echo 'SQL语句执行失败<br>';
			echo '错误编号:'.mysqli_errno($this->dbLink).'<br>';
			echo '错误信息:'.mysqli_error($this->dbLink).'<br>';
			echo '错误的SQL语句:['.$sql.']<br>';
			exit;
		}
		return $result;
	}

	/**
	* 从数据库获取所有数据
	*/
	public function fetchAll($sql,$fetch_type='assoc'){
		$result = $this->query($sql);
		$fetch_types = array('assoc','row','array');
		if(!in_array($fetch_type, $fetch_types)){
			$fetch_type = 'assoc';
		}
		$fetch_fun = 'mysqli_fetch_'.$fetch_type;
		$array = array();
		while ($row = $fetch_fun($result)) {
			$array[] = $row;
		}
		return $array;
	}

	//获取单条记录
	public function fetchRow($sql,$fetch_type='assoc'){
		$result = $this->fetchAll($sql,$fetch_type);
		if(!empty($result)){
			return $result[0];
		}
		return null;
	}

	//获取记录的第一行第一列
	public function fetchColumn($sql){
		$result = $this->fetchRow($sql,'row');
		if(!empty($result)){
			return $result[0];
		}
		return null;
	}
}

 ?>