<?php
class Db{
 protected static $_instance = null;
 protected $dbName = '';
 protected $dsn;
 protected $dbh;
  
 /**
  * 构造
  * $db_host 主机地址
  * $db_user 数据库用户名
  * $db_passwd 数据库密码
  * $db_name  数据库名
  * $db_charset  字符编码
  * $dbport  数据库端口
  * @return MyPDO
  *
  */
public function __construct($dbConfig="")
 {
 	if (!class_exists('PDO')) throw_exception("不支持:PDO");
 	//若没有传输任何参数，则使用默认的数据定义 
			if (!is_array($dbConfig)) { 
					$dbConfig = array( 
					'db_host' => DB_HOST, 
					'db_user' => DB_USER, 
					'db_pass' => DB_PASS, 
					'db_name' => DB_NAME, 
					'db_port' => DB_PORT, 
					'db_type' => DB_TYPE,
					'dsn' => DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME.";post=".DB_PORT ); 
			}
					  try {
                       $dbCharset ='utf8';
					   $this->dbh = new PDO($dbConfig['dsn'],$dbConfig['db_user'],$dbConfig['db_pass'],array(PDO::ATTR_PERSISTENT => true));
      
					   $this->dbh->exec('SET character_set_connection='.$dbCharset.', character_set_results='.$dbCharset.', character_set_client=binary');

					  } catch (PDOException $e) {
					        $this->outputError($e->getMessage());
					  }

 }
  
 /**
  * 防止克隆
  * 
  */
 private function __clone() {}
  
 /**
  * Singleton instance
  * 
  * @return Object
  */
 // public static function getInstance($dbConfig="")
 // {
 //  if (self::$_instance === null) {
 //   self::$_instance = new self($dbConfig);
 //  }
 //  return self::$_instance;
 // }
  
 /**
  * Query 查询
  *
  * @param String $strSql SQL语句
  * @param String $queryMode 查询方式(All or Row)
  * @param Boolean $debug
  * @return Array
  */
 public function query($strSql, $queryMode = 'All', $debug = false)
 {
  if ($debug === true) $this->debug($strSql);
  $recordset = $this->dbh->query($strSql);
  $this->getPDOError();
  if ($recordset) {
   $recordset->setFetchMode(PDO::FETCH_ASSOC);
   if ($queryMode == 'All') {
    $result = $recordset->fetchAll();
   } elseif ($queryMode == 'Row') {
    $result = $recordset->fetch();
   }
  } else {
   $result = null;
  }
  return $result;
 }
  
 /**
  * Update 更新
  *
  * @param String $table 表名
  * @param Array $arrayDataValue 字段与值
  * @param String $where 条件
  * @param Boolean $debug
  * @return Int
  */
 public function update($table, $arrayDataValue, $where = '', $debug = false)
 {
  $this->checkFields($table, $arrayDataValue);
  if ($where) {
   $strSql = '';
   foreach ($arrayDataValue as $key => $value) {
    $strSql .= ", `$key`='$value'";
   }
   $strSql = substr($strSql, 1);
   $strSql = "UPDATE `$table` SET $strSql WHERE $where";
  } else {
 $strSql = "REPLACE INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
  }
  if ($debug === true) $this->debug($strSql);
  $result = $this->dbh->exec($strSql);
  $this->getPDOError();
  return $result;
 }
  
 /**
  * Insert 插入
  *
  * @param String $table 表名
  * @param Array $arrayDataValue 字段与值
  * @param Boolean $debug
  * @return Int
  */
 public function insert($table, $arrayDataValue, $debug = false)
 {
  $this->checkFields($table, $arrayDataValue);
   $strSql = "INSERT INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
  if ($debug === true) $this->debug($strSql);
  $result = $this->dbh->exec($strSql);
  $this->getPDOError();
  return $result;
 }
  
 /**
  * Replace 覆盖方式插入
  *
  * @param String $table 表名
  * @param Array $arrayDataValue 字段与值
  * @param Boolean $debug
  * @return Int
  */
 public function replace($table, $arrayDataValue, $debug = false)
 {
  $this->checkFields($table, $arrayDataValue);
  $strSql = "REPLACE INTO `$table`(`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
  if ($debug === true) $this->debug($strSql);
  $result = $this->dbh->exec($strSql);
  $this->getPDOError();
  return $result;
 }
  
 /**
  * Delete 删除
  *
  * @param String $table 表名
  * @param String $where 条件
  * @param Boolean $debug
  * @return Int
  */
 public function delete($table, $where = '', $debug = false)
 {
  if ($where == '') {
   $this->outputError("'WHERE' is Null");
  } else {
   $strSql = "DELETE FROM `$table` WHERE $where";
   if ($debug === true) $this->debug($strSql);
   $result = $this->dbh->exec($strSql);
   $this->getPDOError();
   return $result;
  }
 }
  
 /**
  * execsql 执行SQL语句
  *
  * @param String $Sql
  * @param Boolean $debug
  * @return Int
  */
 public function execsql($Sql, $debug = false)
 {
  if ($debug === true) $this->debug($Sql);
  $result = $this->dbh->exec($Sql);
  $this->getPDOError();
  return $result;
 }
  
 /**
  * 获取字段最大值
  * 
  * @param string $table 表名
  * @param string $field_name 字段名
  * @param string $where 条件
  */
 public function getMaxValue($table, $field_name, $where = '', $debug = false)
 {
  $strSql = "SELECT MAX(".$field_name.") AS MAX_VALUE FROM $table";
  if ($where != '') $strSql .= " WHERE $where";
  if ($debug === true) $this->debug($strSql);
  $arrTemp = $this->query($strSql, 'Row');
  $maxValue = $arrTemp["MAX_VALUE"];
  if ($maxValue == "" || $maxValue == null) {
   $maxValue = 0;
  }
  return $maxValue;
 }
  
 /**
  * 获取指定列的数量
  * 
  * @param string $table
  * @param string $field_name
  * @param string $where
  * @param bool $debug
  * @return int
  */
 public function getCount($table, $field_name, $where = '', $debug = false)
 {
  $strSql = "SELECT COUNT($field_name) AS NUM FROM $table";
  if ($where != '') $strSql .= " WHERE $where";
  if ($debug === true) $this->debug($strSql);
  $arrTemp = $this->query($strSql, 'Row');
  return $arrTemp['NUM'];
 }
  
 /**
  * 获取表引擎
  * 
  * @param String $dbName 库名
  * @param String $tableName 表名
  * @param Boolean $debug
  * @return String
  */
 public function getTableEngine($dbName, $tableName)
 {
  $strSql = "SHOW TABLE STATUS FROM $dbName WHERE Name='".$tableName."'";
  $arrayTableInfo = $this->query($strSql);
  $this->getPDOError();
  return $arrayTableInfo[0]['Engine'];
 }
  
 /**
  * beginTransaction 事务开始
  */
 private function beginTransaction()
 {
  $this->dbh->beginTransaction();
 }
  
 /**
  * commit 事务提交
  */
 private function commit()
 {
  $this->dbh->commit();
 }
  
 /**
  * rollback 事务回滚
  */
 private function rollback()
 {
  $this->dbh->rollback();
 }
  
 /**
  * transaction 通过事务处理多条SQL语句
  * 调用前需通过getTableEngine判断表引擎是否支持事务
  *
  * @param array $arraySql
  * @return Boolean
  */
 public function execTransaction($arraySql)
 {
  $retval = 1;
  $this->beginTransaction();
  foreach ($arraySql as $strSql) {
   if ($this->execSql($strSql) == 0) $retval = 0;
  }
  if ($retval == 0) {
   $this->rollback();
   return false;
  } else {
   $this->commit();
   return true;
  }
 }
  
 /**
  * checkFields 检查指定字段是否在指定数据表中存在
  *
  * @param String $table
  * @param array $arrayField
  */
protected function checkFields($table, $arrayFields)
 {
  $fields = $this->getFields($table);
  foreach ($arrayFields as $key => $value) {
   if (!in_array($key, $fields)) {
    $this->outputError("Unknown column `$key` in field list.");
   }
  }
 }
  
 /**
  * getFields 获取指定数据表中的全部字段名
  *
  * @param String $table 表名
  * @return array
  */
protected function getFields($table)
 {
  $fields = array();
  $recordset = $this->dbh->query("SHOW COLUMNS FROM $table");
  $this->getPDOError();
  $recordset->setFetchMode(PDO::FETCH_ASSOC);
  $result = $recordset->fetchAll();
  foreach ($result as $rows) {
   $fields[] = $rows['Field'];
  }
  return $fields;
 }
  
 /**
  * getPDOError 捕获PDO错误信息
  */
 private function getPDOError()
 {
  if ($this->dbh->errorCode() != '00000') {
   $arrayError = $this->dbh->errorInfo();
   $this->outputError($arrayError[2]);
  }
 }
  
 /**
  * debug
  * 
  * @param mixed $debuginfo
  */
 private function debug($debuginfo)
 {
  var_dump($debuginfo);
  exit();
 }
  
 /**
  * 输出错误信息
  * 
  * @param String $strErrMsg
  */
 private function outputError($strErrMsg)
 {
  throw new Exception('MySQL Error: '.$strErrMsg);
 }
  
 /**
  * destruct 关闭数据库连接
  */
 public function destruct()
 {
  $this->dbh = null;
 }
// 返回最后插入行的ID或序列值
 public function insert_id(){
   return $this->dbh->lastInsertId();
 }
}