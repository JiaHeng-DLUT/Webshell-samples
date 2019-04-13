<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

$jumpv_insert = $jumpv.'&act=insert';
//-----------

if($act=='insert'){
	$imgname=$_FILES["addr"]["name"] ;
	 $imgsize=$_FILES["addr"]["size"] ;


	
	if(!empty($imgname)){
			$imgtype = gl_imgtype($imgname);		
			//
			//$up_water='y';	//water value is in inc_logcheck.php of lang talbe
			   $ifwater=@htmlentitdm($_POST['water']);
			   $pidstylebh=@htmlentitdm($_POST['iscommon']);
			   $titlehere=@htmlentitdm($_POST['title']);

			   
				if($ifwater=='y') $up_water='y'; 
				 else $up_water='n';
				//-------------------
			$up_small='n';
			$up_delbig='n'; 
			$imgsqlname='';//alway change img name,because the kv img
			$i='';
			require_once('../plugin/upload_img.php');//need get the return value,then upimg part turn to easy.

		/********************/
	$ss = "insert into ".TABLE_IMGFJ." (pbh,pid,lang,title,kv,size,dateedit) values ('$user2510','$pid','".LANG."','$titlehere','$return_v',$imgsize,'$dateall')";//no pos,because pos is auto,is to next and prev page
    //echo $ss;exit;

	 iquery($ss);
	  alert("添加成功");

	}//end not empty
	else {alert('请选择附件！');}

 	 jump($jumpv);	



}//end insert
 
 else{
 $pidstylebh='y';
?>

 
<p style="border:1px solid #ccc;padding:5px;margin-bottom:15px;">
<strong>附件说明：</strong><br />
附件分为名称附件和编辑器附件两种。<br />
<strong>名称附件：</strong>可以用在类似"布局管理"里的输入框里，<span class="cred">不可以用在编辑器里</span><br />
<strong>编辑器附件：</strong>是以http://开头，<span class="cred">而且只可以用在编辑器里</span>
</p>
<?php if($file<>'edit'){?>
<h4 class="h2tit_biao"> 添加附件（图片或文件等）</h4>
<div class="" style="border:1px solid #ccc;padding:5px 22px;margin-bottom:15px;">
<!--  onsubmit="javascript:return -proalbum_add-(this)" -->
        <form  action="<?php echo $jumpv_insert;//here only insert ?>" method="post" enctype="multipart/form-data">
         附件： <input name="title" type="text" id="title" value="" size="30" />
	<div class="c5"> </div>	 
         <input type="file"  id="addr" name="addr"   />
<div class="c5"> </div>

<input type="checkbox" name="water" id="water"  value="y"  checked="checked"   size="10"> <label for="water">加上水印</label>

  
 
                   <div class="c5"> </div>

        <input class="mysubmit" type="submit" name="Submit" value="添加" /></td>
        </form>
<p class="cred" style="padding:5px">说明：可以添加图片或文件等。
<?php
 echo $format_t;
?>
</p> 

</div>
<?php  } ?>

<?php  } ?>
