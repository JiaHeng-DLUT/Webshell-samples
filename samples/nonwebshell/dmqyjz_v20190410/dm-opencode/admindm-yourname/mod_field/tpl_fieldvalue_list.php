<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//-------------

if($act=="update"){
 //pre($_POST);
  
    foreach ($_POST as $k=>$v){
	if($k<>'Submit'){	
		//pre($_POST);exit;
		if(is_array($v)) {
			$v3='';
			  foreach ($_POST[$k] as $k2=>$v2){
				$v3=$v3.$v2.'|';
			  }
			  $v3=substr($v3,0,-1);
			}
			else $v3= $v;
			$v3 = zbdespadd2($v3);			
			 $sqlsub = "SELECT id from ".TABLE_FIELDVALUE." where  pid='$k' and  pidnode='$pid'  $andlangbh order by id limit 1";
				$num22 = getnum($sqlsub);
				if($num22>0){//echo $num22;
					
					  $ss = "update ".TABLE_FIELDVALUE." set value='$v3' where pid='$k' and  pidnode='$pid'  $andlangbh limit 1";
						iquery($ss); 
				}
				else{
					
						$ss = "insert into ".TABLE_FIELDVALUE." (pid,pidnode,pbh,value,lang) values ('$k','$pid','$user2510','$v3','".LANG."')";
						// echo $ss; echo '<br>';
						//exit;
						iquery($ss);
				//echo $num22;
				}
	//	echo $v;
		// echo '<br>';
		
			// $ss = "update ".TABLE_CATE." set  pos='$v' where id='$k'  $andlangbh  limit 1";
			// iquery($ss);
        }//end not submit
	}//end foreach
		
	 jump($jumpv);
}

if($act=="list"){
 $sqlsub = "SELECT * from ".TABLE_FIELD." where  pid='$catpid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
    ?>
 
 <?php 
	  if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有字段，请添加...</p>';
  }
  else{
  
  ?>


 <form method=post action="<?php echo $jumpv;?>&act=update">
  <table class="formtab" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff;">
  
    <td width="25%" align="center">字段名称</td> 
	<td align="center"> </td> 
 
    <?php

   foreach($rowlistsub as $vsub){

           $tid=$vsub['id'];
		   $type_fie=$vsub['typeinput']; 
		   $sta_vis=$vsub['sta_visible']; 
		   $pidname=$vsub['pidname'];  
	
	if($sta_vis=='n')  $tr_hide=' class="tr_hide" ';
	else $tr_hide='';	
	
		$sqlfievalue = "SELECT value from ".TABLE_FIELDVALUE." where  pid='$pidname' and pidnode='$pid'  $andlangbh order by id limit 1";
		$rowfiev = getrow($sqlfievalue);
		//echo $sqlfievalue.'<Br>';
		if($rowfiev<>'no')  $value=$rowfiev['value']; 
		else  $value='';
		//echo $value.'<Br>';
		
		
	  if($type_fie=='checkbox' or $type_fie=='radio' or $type_fie=='select') 
	  {
	   $sqlfieopt = "SELECT id from ".TABLE_FIELDOPTION." where  pid='$pidname'  $andlangbh order by pos desc,id";
	   $fieoptnum=getnum($sqlfieopt);
 
	  
	  $fieldoption = '<a target="_blank" href="mod_fieldoption.php?pid='.$pidname.'&type='.$type_fie.'&lang='.LANG.'">设置字段选项(<span class="cred">'.$fieoptnum.'</span>)</a>';
	  
	  }
	  else $fieldoption ='';
?>
  <tr <?php echo $tr_hide?>>

   <td align="left">
   <strong><?php echo $vsub['name'];?></strong>
     	 <br />
       <?php   echo $pidname;?>
  		<br />
	 	 <?php   echo $fieldoption;?>
	  </td>

      <td> <?php   fieldvalue($pidname,$type_fie,$value); 
	  
	  if($type_fie=='checkbox' ) echo "(必选一个)";
	  ?> 

	  </td>
  
  </tr>
  
  <?php 
  } //end foreach
  ?>

</table>
<p><input class="mysubmit" type="submit" name="Submit" value="提交"></p>
 <?php 
  
  }//end else
	 
?>
</form>
<?php } //end list
?>




<?php 


//field
function fieldvalue($fiepidname,$type,$value22){// echo $value22;  echo '<br />';
	Global $andlangbh;

	// echo $fiepidname.'----'.$type.'-----'.$value22.'---- <br />';
	$i=1;
 
	if($type=='text'){
		 $value22=zbdespedit($value22);
	echo '<input type="text" value="'.$value22.'" name="'.$fiepidname.'" class="form-control" />';
	}
	if($type=='textarea'){
		 $value22=zbdespedit($value22);
	echo '<textarea name="'.$fiepidname.'" class="form-control" rows="8">'.$value22.'</textarea>';
	}
 
		
	if($type=='radio' or $type=='checkbox' or  $type=='select'){
		 $sqlsub = "SELECT id,name,pidname from ".TABLE_FIELDOPTION." where  pid='$fiepidname' and sta_visible='y'  $andlangbh order by pos desc,id";
		  //echo $sqlsub;exit;
		 $rowlistsub = getall($sqlsub);
		 if($rowlistsub=='no') {
		  echo '<p>&nbsp;&nbsp;还没有选项，请添加...</p>';
		  } 
		  else{ if($type=='select') echo '<select name="'.$fiepidname.'">';
					 
			  foreach($rowlistsub as $vv){
					$id = $vv['id'];//id is for input name
				  $namev = $vv['name'];
				  $pidname = $vv['pidname'];
				  
					if($type=='radio'){
						$nameid='rid'.$id.$i;
						if($pidname==$value22){    $checked='checked="checked"';$class='class="cur"';}
						else{   $checked='';$class='';}

		             echo '<input type="radio" '.$checked.' value="'.$pidname.'" name="'.$fiepidname.'" id="'.$nameid.'" size="80" />';
					 echo '<label style="padding-right:20px" for="'.$nameid.'">'.$namev.'</label> ';
					
					}
					if($type=='checkbox'){
						$nameid='cid'.$id.$i;
						 $strpos = strpos($value22,$pidname);	/*只有checkbox会有连接字符串*/					 
						//if(in_array($pidname,$value22)){    $checked='checked="checked"';$class='class="cur"';}
							if(is_int($strpos)){ $checked='checked="checked"';$class='class="cur"';}
						else{ $checked='';$class='';}
		             echo '<input type="checkbox"  '.$checked.'  value="'.$pidname.'" name="'.$fiepidname.'[]" id="'.$nameid.'" size="80" />';
					 echo '<label style="padding-right:20px" for="'.$nameid.'">'.$namev.'</label> ';		
					}
					if($type=='select'){						
						 if($pidname==$value22) $selected=' selected="selected"'; else $selected='';
		             echo '<option  '.$selected.' value="'.$pidname.'">'.$namev.'</option>';	
					}

			  $i++;
			  }//end foreach
		  if($type=='select') echo '</select>';
		  }//end else

		

	 
	}//edn $type=='radio' or $type=='checkbox' or  $type=='select'



}//end func



?>