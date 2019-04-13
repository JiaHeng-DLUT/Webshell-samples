
 <?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php

if($act=='update'){

  // pre($_POST);
//$userprevi = array();
 $userprevi = @$_POST['userprevi'];
 
		//pre($userprevi);
		//echo count($userprevi);
		$whereuserprevi = '';
		if(count($userprevi)>0){
		     
		     
		     if(is_array($userprevi)) {

		     	 
		     	foreach ($userprevi as $v) {

		     			  $ss="select id from  ".TABLE_TAGNODE."  where tag='$v' and node='$pid' $andlangbh limit 1";
						   //echo $ss;exit;
						       if(getnum($ss)==0){	
						       
						       		$ss2 = "insert into ".TABLE_TAGNODE." (pbh,tag,node,lang) values ('".USERBH."','$v','$pid','".LANG."')";
									  //echo $ss;exit;
										iquery($ss2);

						       }

		     		 
		     	} //end foreach


		     		  $ss3="select pidname from  ".TABLE_TAG."  where   $noandlangbh";
						   //echo $ss;exit;
						       if(getnum($ss3)>0){	
							       	$res = getall($ss3);
							       //	pre($res);
							       	foreach ($res as  $v) {
							       		  $pidname = $v['pidname'];
							       		  if (!in_array($pidname, $userprevi)){
							       		  	//echo $pidname;
							       		  	$ssdel ="delete from ".TABLE_TAGNODE." where tag='$pidname' and node='$pid' $andlangbh limit 1";
							       		  	// echo $ssdel;exit;
							       		  	iquery($ssdel);

							       		  }
							       	}

						       }
                       



		     }//end is array

		}
		else{
			//all del tag
			$ssdel ="delete from ".TABLE_TAGNODE." where   node='$pid' $andlangbh";
			 // echo $ssdel;exit;
			 iquery($ssdel);
		}

		$jumpv_insert = $jumpv_file.'&pid='.$pid.'&act=';
		 jump($jumpv_insert);

}
else{
	$jumpv_insert = $jumpv_file.'&pid='.$pid.'&act=update';
?>
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert?>" method="post">

      <?php 
           $sqlcatlist = "SELECT * from ".TABLE_TAG." where    $noandlangbh order by pos desc,id";
  //echo $sqlcatlist;
        $rowcatlist= getall($sqlcatlist);
        //pre($rowcatlist);
        if($rowcatlist<>'no'){
           foreach ($rowcatlist as $k => $v) {

            $c_name = $v['name'];
            $c_pidname = $v['pidname'];
            $c_id = $v['id'];
            
              //-----------
              //strpos(haystack, needle)
              // $strpos = strpos($previ,$c_pidname); /*只有checkbox会有连接字符串*/          
            //if(in_array($pidname,$value22)){    $checked='checked="checked"';$class='class="cur"';}
              //if(is_int($strpos)){ $checked='checked="checked"';$class='class="cur"';}
           // else{ $checked='';$class='';}

 			$checked='';
 			$class='style="padding-right:20px"';

              $ss="select id from  ".TABLE_TAGNODE."  where tag='$c_pidname' and node='$pid' $andlangbh limit 1";
						   //echo $ss;exit;
						       if(getnum($ss)>0){
						       $checked='checked="checked"';$class='style="color:red;padding-right:20px"';

						       }


           
            //--------------
              echo '<input  type="checkbox" '.$checked.' value="'.$c_pidname.'" name="userprevi[]" id="'.$c_id.'" size="80"><label   '.$class.' for="'.$c_id.'">'.$c_name.'</label>';
           }
              


        }

 

      ?>

<p>
       <input  class="mysubmit" type="submit" name="Submit" value="提交">
       </p>
</form>

<?php
}
?>
