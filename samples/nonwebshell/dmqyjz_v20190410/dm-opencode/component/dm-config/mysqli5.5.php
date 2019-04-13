<?php
/*
  power by JASON.ZHANG
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

//http://www.w3school.com.cn/php/php_ref_mysqli.asp
//http://www.runoob.com/php/php-ref-mysqli.html
?>
<?php

/*if mysql5.5 ,use code below*/
$conn = mysqli_connect(
 $mysql_server_name, /* The host to connect to 连接MySQL地址 */
  $mysql_username,   /* The user to connect as 连接MySQL用户名 */
 $mysql_password, /* The password to use 连接MySQL密码 */
 $mysql_database);  /* The default database to query 连接数据库名称*/


// Check connection
if (mysqli_connect_errno($conn))
{
echo  '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />对不起，数据库名，用户或密码不对，请修改component/dm-config/database.php，具体看官方教程 www.demososo.com/install.html   -- sorry,database name maybe is wrong:<br> pls config it in  component/dm-config/database.php';
}






//--------------------------
  mysqli_query($conn,"SET NAMES utf8");
  //-----------------
function query($sql){  Global $conn;
$result = mysqli_query($conn,$sql);

  return $result;
}
function fetch_array($query, $result_type = MYSQLI_ASSOC) {
    return mysqli_fetch_array($query, $result_type);
  }
function num_rows($query) {
    $query = mysqli_num_rows($query);
    return $query;
  }

    // 释放资源
   // mysqli_free_result($result);
    // 关闭连接  mysqli_close($conn);



//-----------------
function getrow($sql) {
    $result = query($sql);
    $rowfirst = fetch_array($result);mysqli_free_result($result);
    if(!$rowfirst)
       $rowfirst='no';
    return $rowfirst;
}

function getall($sql) {
    $result = query($sql);
    $row = fetch_array($result);mysqli_free_result($result);
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
    $rowlist = num_rows($result);mysqli_free_result($result);
    return $rowlist;
}
 function get_numrows($sql) {
    $result = query($sql);
    $rowlist = num_rows($result);mysqli_free_result($result);
    return $rowlist;
}

function iquery($sql) {
    query($sql);
}
function iquery_if($sql) {
    iquery($sql);
   $abc=mysqli_affected_rows();
   if($abc<>1){ alert('sorry,insert error.');exit;}//insert success is 1 else is -1.use avoid dead circle when in block and flashimg(lunh) control.

}
function closesqlconnect() {
    GLOBAL  $conn;  mysqli_close($conn);
}

  // 释放资源
   // mysqli_free_result($result);
    // 关闭连接
   // mysqli_close($conn);




?>
