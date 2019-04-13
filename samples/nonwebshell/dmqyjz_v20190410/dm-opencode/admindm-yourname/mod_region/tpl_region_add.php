<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 
ifhaspidname(TABLE_REGION,$pid);
	
	 

 if($act=='insert')
 {
	
	if($abc1=='') $abc1 = 'pls input title'; 
			 
 $pidnamesub='sreg'.$bshou;

 
 
 
$arr_cfg = 'cssname:##==#==reganchor:##==#==cssstyle:##==#==sta_title:##y==#==sta_width_title:##y==#==sta_width_cnt:##n==#==titleimg:##==#==titlestyle:##==#==titlestylesub:##==#==titlelinelong:##==#==titlelineshort:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##fixed==#==bgrepeat:##no-repeat==#==bgsize:##cover';

$ss = "insert into ".TABLE_REGION." (pid,pidname,pbh,name,lang,dateedit,arr_cfg) values ('$pid','$pidnamesub','$user2510','$abc1','".LANG."','$dateall','$arr_cfg')";
		 //echo $ss;exit;
			iquery($ss);	
 
			jump($jumpv);			
 }



 
else{
 
 
	$name='';
$cssname='';
$clear='';$style='';
$linkurl='';$effect='';
$blockid='';
 


 
?>


<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvf;?>&act=insert" method="post">
  <table class="formtab">
    <tr>
      <td width="20%" class="tr">标题：</td>
      <td width="78%">
       <input name="name" class="curname form-control" type="text" value="<?php echo $name?>"  />
<?php echo $xz_must;?>
        </td>
    </tr>

  
        


<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
 
 <?php
  }
 

?>

 
<script>
function checkhere(thisForm) {
   if (thisForm.name.value==""){
		alert("请输入标题。");
		thisForm.name.focus();
		return (false);
	}

     
  

 
   // return;

}
 


 function selectTOinput_curpage(){
	 $('.selectTOinput_curpage select').change(function(){  
	       var optionv = $(this).children('option:selected').val(); 
		   //console.log(optionv);
		   $(this).parent().children('input').val(optionv);		

		    var curname = $(this).children('option:selected').text(); 
		    $('.curname').val(curname);


	 }); 
	
}

$(document).ready(function(){

	selectTOinput_curpage();

});


</script>

