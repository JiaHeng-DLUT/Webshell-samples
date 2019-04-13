<?php
/*	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);
 
 if($pidname<>'') {ifhaspidname(TABLE_BLOCK,$pidname);}
 
//ifhaspidname(TABLE_NODE,$pid);
//ifhaspidname(TABLE_CATE,$catpid);
ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$jumpv='mod_smtp.php?lang='.LANG;
$jumpv_pidname=$jumpv.'&pidname='.$pidname;
$jumpv_file=$jumpv.'&file='.$file;
$jumpv_pidnamefile=$jumpv_pidname.'&file='.$file;


//----
$submenu='module';
$title = '邮件管理';

 
//-----------

require_once HERE_ROOT.'mod_common/tpl_header.php'; 

?>

<section class="content-header">   
      <h1><?php echo $title?></h1>
</section>

<section class="content">

<?php

$jumpv_insert = $jumpv.'&act=update';

if($act=='update'){



   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  $bscnt22 = '';
  if(count($_POST)>1){
          foreach ($_POST as  $k=>$v) {
            if(strtolower($k)=='submit') break;
            $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
             
          }
      }
       $bscnt22 = substr($bscnt22,0,-5);



	 $ss = "update ".TABLE_LANG." set arr_smtp='$bscnt22' where lang='".LANG."' limit 1";
	 iquery($ss); 	

  jump($jumpv);

}
else{


  $sql = "SELECT arr_smtp from ".TABLE_LANG."  where lang='".LANG."' order by id limit 1";
//echo $sql;//exit;

$row22 = getrow($sql);
$arr_smtp=$row22['arr_smtp'];


$bscntarr = explode('==#==',$arr_smtp); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }




?>

<p>
当用户给网站留言时，如果您同时希望可以把留言发到您的邮箱，则在这里设置。
<br />
邮件发送借助第三方邮箱系统，比如网易邮箱或qq邮箱等。
<br />
是否发送成功，取决于您的设置。是否支持在本地测试，取决于第三方邮箱系统。第三方系统如果监测您是本地测试，一般会阻止发送邮件。
 </p>
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert;?>" method="post">
  <table class="formtab">
    <tr>
      <td width="12%" class="tr">是否开通SMTP功能：</td>
      <td width="88%"> 
         <select name="smtp_active">
    <?php select_from_arr($arr_yn,$smtp_active,'');?>
     </select> 
 <br />
      <span class="cgray">默认是关闭的。</span>
      </td>
    </tr>
    <tr>
      <td width="12%" class="tr">SMTP服务器：</td>
      <td width="88%"> <input name="smtp_server" type="text"  value="<?php echo $smtp_server;?>" class="form-control" />
      </td>
    </tr>
	  <tr>
      <td   class="tr">SMTP服务器端口：</td>
      <td  > <input name="smtp_port" type="text"  value="<?php echo $smtp_port;?>" class="form-control" />
      <span class="cgray">一般是25 ，但是不同的邮箱系统，可能会不一样。</span>
      </td>
    </tr>
     <tr>
      <td   class="tr">电子邮箱账号：</td>
      <td  > <input name="smtp_email" type="text"  value="<?php echo $smtp_email;?>" class="form-control" />
      <span class="cgray">同时也是收件人</span>
      </td>
    </tr>
     <tr>
      <td   class="tr">电子邮箱密码：</td>
      <td  > <input name="smtp_ps" type="text"  value="<?php echo $smtp_ps;?>" class="form-control" />
      </td>
    </tr>
 
 
	<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
	  </table>
    <?php echo $inputmust;?>

</form>
 


<?php
}
?>

</section>
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';

?>