<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 //if($pidname<>'') {ifhaspidname(TABLE_BLOCK,$pidname);}
 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$jumpv='mod_bakdata.php?lang='.LANG;
$jumpv_pidname=$jumpv.'&pidname='.$pidname;
$jumpv_file=$jumpv.'&file='.$file;
$jumpv_pidnamefile=$jumpv_pidname.'&file='.$file;


//----
$submenu='module';
$title = '备份数据库 ';

 

if($act=='del'){
  //  echo $pidname;
   unlinkdm($pidname);
   jump($jumpv);

} 
//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php'; 
 ?>

 <section class="content-header">   
      <h1><?php echo $title?></h1>
</section>

<section class="content">
 <p><a href="<?php echo $jumpv;?>&act=bak">点击开始备份数据库</a>
<br />
<span class="cred">备份功能，不适合于高版本的mysql，比如mysql5.5以上。mysql5.5以上可以用phpmyadmin等工具。 </span>
</p> 

<?php

 

  if($act=='bak'){
   echo  '<div style="padding:50px"><a href="'.$jumpv.'&act=baktrue">确定要备份数据库吗？</a><br /><br />';

   echo  '<a href="'.$jumpv.'">取消备份></a><br /><br /><br /></div>';

  }
 else if($act=='baktrue'){
$mysql = '';
     mysql_connect($mysql_server_name,$mysql_username,$mysql_password);        
     mysql_select_db($mysql_database);        
          mysql_query("SET NAMES utf8");
    $q1=mysql_query("show tables");        
    while($t=mysql_fetch_array($q1)){   
        $table=$t[0];        
        $q2=mysql_query("show create table `$table`");   
        $sql=mysql_fetch_array($q2);        
        $mysql.=$sql['Create Table'].";\r\n\r\n";      
        $q3=mysql_query("select * from `$table`");   
        while($data=mysql_fetch_assoc($q3)) {       
            $keys=array_keys($data);        
            $keys=array_map('addslashes',$keys);        
            $keys=join('`,`',$keys);        
            $keys="`".$keys."`";        
            $vals=array_values($data);        
            $vals=array_map('addslashes',$vals);       
            $vals=join("','",$vals);        
            $vals="'".$vals."'";        
            $mysql.="insert into `$table`($keys) values($vals);\r\n";   
         }        
        $mysql.="\r\n";                
     }        
    $filename=date('Ymd-his').'_'.rand(1111,9999)."_data.sql"; //文件名为当天的日期        
  $fp = fopen('../bakdata/'.$filename,'w');       // $fp = fopen('baksqlfile/'.$filename,'w');    
    fputs($fp,$mysql);        
     fclose($fp);        
  
  alert('备份成功！');
  jump($jumpv);

}
else{
  echo '<div style="padding:20px;margin-top:10px;line-height:22px"><strong>已备份的数据库:</strong>(右键--另存为 下载到本地)<br /><br />';



 //要按时间 排序： 
 
$dir_name="../bakdata"; 
 
$dir = opendir($dir_name); 
$basename = basename($dir_name); 
$fileArr = array(); 
 
while ($file_name = readdir($dir)) 
{ 
if (($file_name !=".") && ($file_name != "..")) 
{ 
//Get file modification date... 
$fName = "$dir_name/$file_name"; 
$fTime = filemtime($fName); 
$fileArr[$file_name] = $fTime; 
} 
} 
 
# Use arsort to get most recent first 
# and asort to get oldest first 
arsort($fileArr); 
 
$numberOfFiles = sizeOf($fileArr); 
for($t=0;$t<$numberOfFiles;$t++) 
{ 
$thisFile = each($fileArr); 
$thisName = $thisFile[0]; 
$thisTime = $thisFile[1]; 
$thisTime = date("d M y", $thisTime); 
//echo"文件名： $thisName -- 时间 ： $thisTime <br />";
 $filedm = $dir_name.'/'.$thisName;

  $jsname = jsdelname($thisName);
  
 //$del_text= " <a href=javascript:del('del','$filedm','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
 $del_text='';  // no need del func.

 echo '文件名： <a href="'.$filedm.' " target="_blank">'.$filedm.' </a>   '.$del_text.'<br />'; 
} 
closedir ($dir); 
 

/*
  function treedm($dir)
      {
          $mydir = dir($dir);
          while($file = $mydir->read())
          {
              if($file != '.' && $file != '..')
              {
                  if(is_dir("$dir/$file"))
                  {
                     // echo '目录名：'.$dir.DIRECTORY_SEPARATOR.'<font color="red">'.$file.'</font><br />';
                     // tree("$dir/$file");
                  }else{
                      $filedm = $dir.'/'.$file;
                      echo '文件名： <a href="'.$filedm.' ">'.$filedm.' </a><br />';
                  }
              }
          }
          $mydir->close();
      }
      treedm('../bakdata');*/
      echo '</div>';
     
}
 ?>
 </section>

<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>