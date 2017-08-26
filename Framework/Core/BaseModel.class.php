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
    
    /**
     * 获取表名
     */
    protected function getTableName(){
        return substr(get_class($this),0,-5);
    }
    
    /**
     * 获取主键列
     * @param array $data 跟数据表对应的结构数组
     */
    private function getPk(){
        $rs = $this->db->query("describe `{$this->getTableName()}`");
        while ($row = mysqli_fetch_assoc($rs)){
            if($row['Key'] == 'PRI'){
                return $row['Field'];
            }
        }
        return null;
    }
    
    /**
     * 通用添加方法
     * @param array $data 跟数据表对应的结构数组
     */
    public function insert($data){
        $keys = array_keys($data);
        $values = array_values($data);
        $keys = array_map(function($item){
            return "`{$item}`";
        }, $keys);
        $keys_str = implode(',', $keys);
        $values = array_map(function($item){
            return "'{$item}'";
        }, $values);
        $values_str = implode(',', $values);
        $sql = "insert into `{$this->getTableName()}`({$keys_str}) values({$values_str})";
        
        $rs = $this->db->query($sql);
        return $rs;
    }
    
     /**
     * 通用修改方法
     * @param array $data 跟数据表对应的结构数组
     */
    public function update($data){
        $keys = array_keys($data);
                
        //分离主键
        $fieldPk = $this->getPk();
        if(!in_array($fieldPk, $keys)){
            die('修改语句没有设置主键标识');
        }
        
        $pkIndex = array_search($fieldPk, $keys);
        if($pkIndex > -1){
            unset($keys[$pkIndex]);      
        }
        $upFieldKv = array_map(function($item) use($data){
            return "`{$item}`='{$data[$item]}'";
        }, $keys);
        $upFieldKv_str = implode(',', $upFieldKv);
        $sql = " update `{$this->getTableName()}` set {$upFieldKv_str} where `{$fieldPk}`='{$data[$fieldPk]}' ;  ";
        
        $rs = $this->db->query($sql);
        return $rs;
        
    }
    
    /**
     * 通用删除方法
     * @param array $data 跟数据表对应的结构数组
     */
    public function delete($data){
        //获取主键
        $fieldPk = $this->getPk();
        if(!array_key_exists($fieldPk, $data)){
            die('修改语句没有设置主键标识');
        }
        $sql = " delete from `{$this->getTableName()}` where `{$fieldPk}`='{$data[$fieldPk]}' ";
        return $this->db->query($sql);
    }
    
    /**
     * 通用查询方法
     * @param string $field 排序列
     * @param string $order 排序方式,默认正序
     */
    public function select($field='',$order='asc'){
        $sql = "select * from `{$this->getTableName()}` ";
        if(!$field == ''){
            $sql .= " order by `{$field}` {$order}";
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * 获取单条记录
     * @param int $pk_value 主键值
     * @return type array
     */
    public function single($pk_value){
        $sql = "select * from `{$this->getTableName()}` where `{$this->getPk()}`='{$pk_value}'";
        return $this->db->fetchRow($sql);
    }
    
}

 ?>