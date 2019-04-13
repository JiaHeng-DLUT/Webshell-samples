<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

 
 
 if($act=='update')
 {
 //pre($_POST);
//$userprevi = array();
 $userprevi =$_POST['userprevi'];
 $abc1 = @htmlentitdm($_POST['email']);
 $abc2 = @htmlentitdm($_POST['password']);
 $user_stanoaccess = @htmlentitdm($_POST['user_stanoaccess']);
 //pre($userprevi);
//echo count($userprevi);
$whereuserprevi = '';
//if(count($userprevi)>0){
       $v3='';
       if(is_array($userprevi)) {
           foreach ($userprevi as $k2=>$v2){
            $v3=$v3.$v2.'|';
            }

            $v3 =  htmlentitdm($v3);
         }   
        
        $whereuserprevi = ",previ= '$v3'";

//}

 // exit;
    if($abc1<>''){

       $sql = "SELECT * from ".TABLE_USER."  where email='$abc1' and id<>'$tid'  order by id limit 1";
       if(getnum($sql)>0) {
        alert('管理员重名！'); 
        jump($jumpvf.'&act=edit&tid='.$tid);}

  }
 

    if($abc2<>'') { 
         $pscrypt= htmlentitdm(crypt($abc2, $salt));
        $whereps = ",ps= '$pscrypt'";
    }
    else  $whereps = "";

   if($abc1 == '') $abc1 = '请输入名称';
       $ss = "update ".TABLE_USER." set email='$abc1',user_stanoaccess='$user_stanoaccess' $whereps  $whereuserprevi where id='$tid' and type='normal' limit 1";
      iquery($ss);  
     // echo $ss;exit;

      if($abc2<>'') alert('密码已修改。');

        jump($jumpvf.'&act=edit&tid='.$tid); 
 }
 
 
 else {
 
  
$sql = "SELECT * from ".TABLE_USER."  where id='$tid'  order by id limit 1";
$row222 = getrow($sql);
//$desp=zbdesp_imgpath($row['desp']);
$email= $row222['email']; $jsname = jsdelname($email);
   
$previ= $row222['previ'];
$user_stanoaccess= $row222['user_stanoaccess'];
$ps='';
 
 $jumpv_insert = $jumpvf.'&act=update&tid='.$tid;
 
 
?>
 
 <div class="contenttop">
  <a class='del fr but2'  href=javascript:delid('deluser','<?php echo $tid?>','<?php echo $jumpv?>','<?php echo $jsname;?>')>
    <i class="fa fa-trash-o"> </i> 删除</a>  
</div>

<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert?>" method="post">
  <table class="formtab">
    <tr>
      <td width="22%" class="tr">管理员名称：</td>
      <td width="77%"> <input name="email" type="text" autocomplete="off" value="<?php echo $email?>" class="form-control"><?php echo $xz_must; ?> 
       </td>
    </tr>

     <tr>
      <td   class="tr">密码：</td>
      <td  > <input name="password" type="password" autocomplete="off" value="<?php echo $ps;?>" class="form-control"> 
      <br /> <span class="cgray">如果不修改密码，请留空。</span>
       </td>
    </tr>

     <tr>
      <td  class="tr">选择权限：</td>
      <td  > 

      <?php 
           $sqlcatlist = "SELECT * from ".TABLE_CATE." where  pid='0' and modtype='node' $andlangbh order by pos desc,id";
  //echo $sqlcatlist;
        $rowcatlist= getall($sqlcatlist);
        //pre($rowcatlist);
        if($rowcatlist<>'no'){
           foreach ($rowcatlist as $k => $v) {

            $c_pidname = $v['pidname'];
             $c_name = $v['name'];

              $c_id = $v['id'];
              //-----------
              //strpos(haystack, needle)
               $strpos = strpos($previ,$c_pidname); /*只有checkbox会有连接字符串*/          
            //if(in_array($pidname,$value22)){    $checked='checked="checked"';$class='class="cur"';}
              if(is_int($strpos)){
                 $checked='checked="checked"';$class='class="cur"';
                 $c_name = '<span class="cred">'.$c_name.'</span>';
                }
            else{ $checked='';$class='';}
            //--------------
              echo '<input type="checkbox" '.$checked.' value="'.$c_pidname.'" name="userprevi[]" id="'.$c_id.'" size="80"><label style="padding-right:20px" for="'.$c_id.'">'.$c_name.'</label>';
           }
              


        }

 

      ?>

        
       
   


       </td>
    </tr>


   <tr>
      <td   class="tr">禁止访问：</td>
      <td  >
       <select name="user_stanoaccess">
    <?php select_from_arr($arr_yn,$user_stanoaccess,'');?>
  </select>
<br />
<span class="cgray">此管理员发布的文章 是否 设置为禁止访问</span>

       </td>
    </tr>


    
 
<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="修改"></td>
    </tr>
  </table>
</form>

<?php } ?>
 

<script>
function checkhere(thisForm) {
   if (thisForm.name.value=="")
  {
    alert("请输入名称。");
    thisForm.name.focus();
    return (false);
  }
 
   /* var sm_w = parseInt(thisForm.sm_w.value);
  var sm_h = parseInt(thisForm.sm_h.value);
  if(sm_w<20){
      alert("必须大于20。");
    thisForm.sm_w.focus();
    return (false)
      
  }
    if(sm_h<20){
      alert("必须大于20。");
    thisForm.sm_h.focus();
    return (false)
      
  }
  

   if (!isnum(thisForm.sm_w.value))
  {
    alert("必须为数字。");
    thisForm.sm_w.focus();
    return (false);
  }
  
   if (!isnum(thisForm.sm_h.value))
  {
    alert("必须为数字。");
    thisForm.sm_h.focus();
    return (false);
  }
  */

   // return;

}
 

</script>
