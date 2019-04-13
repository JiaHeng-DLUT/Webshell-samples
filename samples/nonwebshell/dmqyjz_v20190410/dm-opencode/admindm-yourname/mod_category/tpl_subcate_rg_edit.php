<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php
	
	if($act=='update'){  

        //pre($_POST);
		//exit;

		if($abc2==$pidname) {
		 	alert('父级分类不能是自己！'); 
		 	 jump($jumpvedit);
		 	  }
	 
		 if($abc1=="" or strlen($abc1)<3) {
		 	alert('请输入分类名称或字太少！'); 
		 	 jump($jumpvedit);
		 	  }
		//if($abc3=="" or strlen($abc3)<3) {alert('请输入别名或字太少！');  jump($jumpv_editsub); }
		//if(!in_array($catid,$art_cat_id)){alert('先选择父级分类。');jump($PHP_SELF);}
		//--------------------
	 
		//ifhaspidname(TABLE_CATE,$abc2);


		//-------------------------
		$catpidname_qian3=substr($abc2,0,3); 
		if($catpidname_qian3<>'cat')  {
		 
		$ss = "SELECT id from ".TABLE_CATE." where pid='$pidname' $andlangbh  limit 1";
		//$sub_pidname in mod file
				$row=getrow($ss);				 
				  if($row<>'no'){
							alert('出错，此分类下有子分类，不能改变分类的值，请先移走它的子分类。');//only judge when father cat is sub cat
							 jump($jumpvedit);
						}
						
		 }		

	 

		 $arrcanexcerpt =  array("name", "pid", "alias_jump","sta_noaccess");  //move top 
        
		 $bscnt22 = '';
		 if(count($_POST)>1){
						 foreach ($_POST as  $k=>$v) {
								if(strtolower($k)=='submit') break;
							 if(in_array($k,$arrcanexcerpt))   continue;
	 
							 $bscnt22 .= $k.':##'.htmlentitdm(trim($v)).'==#==';
								
						 }
				 }
					$bscnt22 = substr($bscnt22,0,-5);

					

      $ss = "update ".TABLE_CATE." set name='$abc1',sta_noaccess='$abc2',alias_jump='$abc3',sta_listcan_inherit='$abc4',list_can='$bscnt22'  where pidname='$pidname' $andlangbh limit 1";

			iquery($ss); 	
		    jump($jumpvedit);
	
	}

 if($act=='edit'){
 
		
		  $pidnamesub=$row['pidname']; $pidsub=$row['pid'];
		  $sta_noaccess=$row['sta_noaccess'];
		  $name=$row['name'];
 
		  $alias_jump=$row['alias_jump'];
			$sta_listcan_inherit=$row['sta_listcan_inherit'];

			$cssname=$template=$detailfg=$nodebtnmore=$albumfg=$videofg=$musicfg='';
			$maxline=20;
			$cus_columns=3;
			$cus_substrnum=30;
		 $sm_w=$sm_h=300;
	

	 
	 $pidcatename = get_field(TABLE_CATE,'name',$pidsub,'pidname');

}	 



  
	
if($act=='edit')	{
?>


  <div class="contenttop">

   <a class="needpopup" href="../mod_seo/mod_seo_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=cate"><i class="fa fa-pencil-square-o"></i> 修改SEO</a>

&nbsp;&nbsp;&nbsp;&nbsp;
  <a class="needpopup" href="../mod_seo/mod_alias_edit.php?lang=<?php echo LANG;?>&act=edit&pidname=<?php echo $pidname;?>&type=cate"><i class="fa fa-pencil-square-o"></i> 修改别名</a> 
  <?php 
  $alias= alias($pidname,'cate');
  if($alias<>'') echo '( '.spangray($alias).' )';
  ?> 
</div>



<form  onsubmit="javascript:return catsub(this)" action="<?php  echo $jumpvf;?>&act=update&pidname=<?php echo $pidname?>" method="post" enctype="multipart/form-data">
<table class="formtab">

  <tr>
    <td width="12%" class="tr">分类名称：</td>
    <td width="88%"><input  name="name" type="text" id="name" value="<?php echo $name?>" class="form-control" />
     </td>
  </tr>
 
  
<tr>
    <td width="12%" class="tr">父级:</td>
    <td width="88%"><?php echo $pidcatename;?>
 
	<a class="needpopup" href="mod_pop_editparent.php?lang=<?php echo LANG;?>&pidname=<?php echo $pidname?>">重新选择父级</a> 
 </td>
  </tr>
    <tr>
      <td  class="tr">禁止访问：</td>
      <td   ><select name="sta_noaccess">
	  <?php select_from_arr($arr_yn,$sta_noaccess,'');?>
     </select>
	 
	 <?php
	 if($sta_noaccess=='y') echo '<span style="color:red">禁止访问</span>';
	 ?>
        </td>
    </tr>

      <tr>
    <td class="tr">链接跳转：</td>
    <td><input name="alias_jump" type="text"  value="<?php echo $alias_jump?>" class="form-control" />
	  <?php echo $aliasjumptext.$xz_maybe;?>
      <?php if($row['alias_jump']<>'') { echo $text_jump;
      }?>
     </td>
  </tr> 
   
	<tr>
<td colspan="2" class="trbg">
  子分类的其他参数
</td></tr>
  <tr>
      <td  class="tr">是否继承主类：</td>
      <td   ><select name="sta_listcan_inherit">
	  <?php select_from_arr($arr_yn,$sta_listcan_inherit,'');?>
     </select>
	 
	 <?php
	 if($sta_listcan_inherit=='y') echo '<p style="margin-top:10px;padding:5px;background:red;color:#fff">如果继承主类，则下面的设置在前台不起作用。默认为继承。</p>';
	 ?>
        </td>
    </tr>


	 <?php        
        require_once HERE_ROOT.'mod_category/plugin_catelist_can.php';
        ?>
       



  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="修改"></td>
  </tr>
 </table>
</form>

  <?php } ?>
