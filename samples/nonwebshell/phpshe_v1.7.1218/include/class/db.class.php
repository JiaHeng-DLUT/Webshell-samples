<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */
class db { 
	public $link;
	public $link_type;
	public $page;
	public $table_index;
	public $sql;
	public function __construct($db_host, $db_user, $db_pw, $db_name, $db_coding, $init = true)
	{

		$this->link_type = function_exists("mysqli_connect") ? 'mysqli' : 'mysql';
		if ($init) {
			$result = $this->connect($db_host, $db_user, $db_pw);
			if ($result != 'success') pe_bug($result, __LINE__);
			$result = $this->select_db($db_name, $db_coding);		
			if ($result != 'success') pe_bug($result, __LINE__);
		}
	}
	//连接数据库
	public function connect($db_host, $db_user, $db_pw)
	{
		if ($this->link_type == 'mysqli') {
			$this->link = mysqli_connect($db_host, $db_user, $db_pw);
		}
		else {
			$this->link = mysql_connect($db_host, $db_user, $db_pw);
		}
		if ($this->link) {
			return 'success';
		}
		else {
			return '数据库连接失败，数据库IP/用户名/密码错误';
		}
	}
	//选择数据库
	public function select_db($db_name, $db_coding)
	{
		if ($this->link_type == 'mysqli') {
			$result = mysqli_select_db($this->link, $db_name);
		}
		else {
			$result = mysql_select_db($db_name, $this->link);
		}
		if ($result) {
			$this->query("SET NAMES {$db_coding}");
			$this->query("SET sql_mode = ''");
			return 'success';
		}
		else {
			return "数据库连接成功，但数据库 {$db_name} 不存在";	
		}
	}
	//执行sql语句
  	public function query($sql)
  	{
  		$this->sql[] = $sql;
		if ($this->link_type == 'mysqli') {
			$result = mysqli_query($this->link, $sql);
			if ($sqlerror = mysqli_error($this->link)) $this->sql[] = $sqlerror;
		}
		else {
			$result = mysql_query($sql, $this->link);
			if ($sqlerror = mysql_error($this->link)) $this->sql[] = $sqlerror;
		}
		return $result;
  	}
  	//获取关联数组集
	public function fetch_assoc($result = null)
	{
		if ($this->link_type == 'mysqli') {
  			return mysqli_fetch_assoc($result);
		}
		else {
  			return mysql_fetch_assoc($result);
		}
  	}
  	//获取索引数组集
  	public function fetch_row($result = null)
  	{
		if ($this->link_type == 'mysqli') {
  			return mysqli_fetch_row($result);
		}
		else {
  			return mysql_fetch_row($result);
		}
  	}
  	//获取select结果集条数
	public function num_rows($result = null)
  	{
		if ($this->link_type == 'mysqli') {
  			return mysqli_num_rows($result);
		}
		else {
  			return mysql_num_rows($result);
		}
  	}
  	//获取insert/update/delete结果集条数
	public function affected_rows()
	{
		if ($this->link_type == 'mysqli') {
			$result = mysqli_affected_rows($this->link);
		}
		else {
			$result = mysql_affected_rows();
		}
		return $result > 0 ? $result : 0;		
	}  	
	//获取自增id
	public function insert_id()
	{
		if ($this->link_type == 'mysqli') {
			return mysqli_insert_id($this->link);
		}
		else {
			return mysql_insert_id();
		}
	}
	//按自定义索引生成数据
	public function index($table_index)
	{
		$this->table_index = $table_index;
		return $this;
	}
	public function version() {
		if ($this->link_type == 'mysqli') {
			return 'MySQLi '.mysqli_get_server_info($this->link);
		}
		else {
			return 'MySQL '.mysql_get_server_info();
		}
	}
	/* ====================== 原始mysql处理函数 ====================== */
	public function sql_insert($sql)
	{
		$this->query($sql);
		if ($insert_id = $this->insert_id()) {
			return $insert_id;
		}
		else {
			return $this->affected_rows();
		}
	}
	public function sql_delete($sql)
	{
		$this->query($sql);
		return $this->affected_rows();
	}
	public function sql_update($sql)
	{
		if ($this->query($sql) == true) {
			$result = $this->affected_rows();
			return $result == 0 ? true : $result;
		}
		return 0;		
	}
	public function sql_selectall($sql, $limit_page = array())
	{
		//每页数量显示+分页 or 每页数量显示+不分页
		if (count($limit_page)==2) {
			$allnum = $this->sql_num(preg_replace('/select [\s\S]+?(?!from) from/', 'select count(1) from', $sql, 1));
			$this->page = new page($allnum, $limit_page[1], $limit_page[0]);
			$sqllimit = $this->page->limit;
		}
		elseif (count($limit_page)==1) {
			$sqllimit = " limit {$limit_page[0]}";
		}

		$result = $this->query($sql.$sqllimit);
		$rows = array();
		//自定义索引
		if ($this->table_index) {
			$table_index = explode('|', $this->table_index);
			$table_index_num = count($table_index);
			unset($this->table_index);
		}
		else {
			$table_index_num = 0;
		}
		while ($row = $this->fetch_assoc($result)) {
			if ($table_index_num == 0) {
				$rows[] = $row;
			}
			elseif ($table_index_num == 1) {
				$rows[$row[$table_index[0]]] = $row;
			}
			elseif ($table_index_num == 2) {
				$rows[$row[$table_index[0]]][$row[$table_index[1]]] = $row;
			}
		}
		return $rows;
	}
	public function sql_select($sql)
	{
		$row = array();
		return $row = $this->fetch_assoc($this->query($sql));
	}
	//可以用于判断符合sql条件的总行数(但sql必须遵循 "select count(1) from table where条件")合适，也可以用户判断某行是否存在
	public function sql_num($sql)
	{
		$rows = $this->fetch_row($this->query($sql));
		return intval($rows[0]);
	}
	/* ====================== 快速mysql处理函数 ====================== */
	public function pe_selectall($table, $where = '', $field = '*', $limit_page = array())
	{
		//处理条件语句
		$sqlwhere = $this->_dowhere($where);
		return $this->sql_selectall("select {$field} from `".dbpre."{$table}` {$sqlwhere}", $limit_page);
	}
	public function pe_select($table, $where = '', $field = '*')
	{
		//处理条件语句
		$sqlwhere = $this->_dowhere($where);
		return $this->sql_select("select {$field} from `".dbpre."{$table}` {$sqlwhere} limit 1");
	}
	public function pe_insert($table, $set)
	{
		//处理设置语句
		$sqlset = $this->_doset($set);
		return $this->sql_insert("insert into `".dbpre."{$table}` {$sqlset}");
	}
	public function pe_update($table, $where, $set)
	{
		//处理设置语句
		$sqlset = $this->_doset($set);
		//处理条件语句
		$sqlwhere = $this->_dowhere($where);
		return $this->sql_update("update `".dbpre."{$table}` {$sqlset} {$sqlwhere}");	
	}
	public function pe_delete($table, $where = '')
	{
		//处理条件语句
		$sqlwhere = $this->_dowhere($where);
		return $this->sql_delete("delete from `".dbpre."{$table}` {$sqlwhere}");
	}
	public function pe_num($table, $where = '')
	{
		//处理条件语句
		$sqlwhere = $this->_dowhere($where);
		return $this->sql_num("select count(1) from `".dbpre."{$table}` {$sqlwhere}");
	}
	public function sql($type=0)
	{
		$i = 1;
		foreach ((array)$this->sql as $k => $v) {
			if ($k <=1) {
				continue;
			}
			else {
				if ($type) {
					echo  "[".($i++)."] => {$v}\r\n";				
				}
				else {
					echo  "<p>[".($i++)."] => {$v}</p>";				
				}
			}
		}
	}
	/* ====================== 仅供内部调用 ====================== */
	//处理条件语句
	protected function _dowhere($where)
	{
		if (is_array($where)) {
			foreach ($where as $k => $v) {
				$k = str_ireplace('`', '', $k);
				if (is_array($v)) {
					$where_arr[] = "`{$k}` in('".implode("','", $v)."')";			
				}
				else {
					in_array($k, array('order by', 'group by')) ? ($sqlby .= " {$k} {$v}") : ($where_arr[] = "`{$k}` = '{$v}'");
				}
			}
			$sqlwhere = is_array($where_arr) ? 'where '.implode($where_arr, ' and ').$sqlby : $sqlby;
		}
		else {
			$where && $sqlwhere = (stripos(trim($where), 'order by') === 0 or stripos(trim($where), 'group by') === 0) ? "{$where}" : "where 1 {$where}";
		}
		return $sqlwhere;
	}
	//处理设置语句
	protected function _doset($set)
	{
		//仅针对insert插入多条数据
		if (is_array($set) && count($set, 1) > count($set)) {			
			foreach ($set as $set_one) {
				$key_arr = $val_arr = array();
				foreach ($set_one as $k => $v) {
					$key_arr[] = str_ireplace('`', '', $k);
					$val_arr[] = "'{$v}'";
				}
				$val_str[] = "(" . implode($val_arr, ', ') . ")";
			}
			$key_str = "(" . implode($key_arr, ', ') . ")";
			$sqlset = "{$key_str}  values ".implode($val_str, ', ');
		}
		elseif (is_array($set) && count($set, 1) == count($set)) {	
			foreach ($set as $k => $v) {
				$k = str_ireplace('`', '', $k);
				$set_arr[] = "`{$k}` = '{$v}'";
			}
			$sqlset = 'set '.implode($set_arr, ' , ');
		}
		else {
			$sqlset = "set {$set}";
		}
		return $sqlset;
	}
}
?>