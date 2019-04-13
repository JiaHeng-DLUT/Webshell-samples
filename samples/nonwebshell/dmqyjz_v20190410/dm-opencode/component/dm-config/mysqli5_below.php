<?php
/*
  power by JASON.ZHANG
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>
<?php


$conn = mysql_connect($mysql_server_name, $mysql_username,$mysql_password,'utf-8');
 if (!$conn) {
    die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />对不起，数据库的用户或密码不对，请仔细检查component/dm-config/database.php的配置。。。。。。具体看官方教程 www.demososo.com/install.html   - sorry,localhost,usename or ps maybe is wrong....Could not connect:<br> pls visit later');
    }
    // mysql_error()
mysql_select_db($mysql_database, $conn) or die ('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 出错，数据库可能不存在。请先用phpmyadmin导入sql文件。或者仔细检查数据库名称。。。。。。。具体看官方教程 www.demososo.com/install.html  - sorry,database name maybe is wrong:<br> pls visit later');



//--------------------------
  mysql_query("SET NAMES utf8");
  //-----------------
function query($sql){ // echo $sql;
$result = mysql_query($sql);

  return $result;
}
function fetch_array($query, $result_type = MYSQL_ASSOC) {
    return mysql_fetch_array($query, $result_type);
  }
function num_rows($query) {
    $query = mysql_num_rows($query);
    return $query;
  }

    // 释放资源
   // mysql_free_result($result);
    // 关闭连接  mysql_close($conn);



//-----------------
function getrow($sql) {
    $result = query($sql);
    $rowfirst = fetch_array($result);mysql_free_result($result);
    if(!$rowfirst)
       $rowfirst='no';
    return $rowfirst;
}

function getall($sql) {
    $result = query($sql);
    $row = fetch_array($result);mysql_free_result($result);
    if($row){
       $result = query($sql);
       while($row = fetch_array($result)){
           $rowlist[] = $row;
       }
    }
    else
    $rowlist='no';
    return $rowlist;
}
function getnum($sql) {
    $result = query($sql);
    $rowlist = num_rows($result);mysql_free_result($result);
    return $rowlist;
}
 function get_numrows($sql) {
    $result = query($sql);
    $rowlist = num_rows($result);mysql_free_result($result);
    return $rowlist;
}

function iquery($sql) {
    query($sql);
}
function iquery_if($sql) {
    iquery($sql);
   $abc=mysql_affected_rows();
   if($abc<>1){ alert('sorry,insert error.');exit;}//insert success is 1 else is -1.use avoid dead circle when in block and flashimg(lunh) control.

}
function closesqlconnect() {
    GLOBAL  $conn;  mysql_close($conn);
}

  // 释放资源
   // mysql_free_result($result);
    // 关闭连接
   // mysql_close($conn);




?>
